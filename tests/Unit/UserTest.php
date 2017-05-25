<?php

namespace Tests\Unit;

use App\Models\Cycle;
use App\Models\Team;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Week;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function can_get_list_of_users_not_signed_up_for_a_given_cycle()
    {
        $cycle = factory(Cycle::class)->create();
        $startTime = $cycle->starts_at;
        $cycle->weeks()->saveMany([
            factory(Week::class)->make([
                'starts_at' => $startTime
            ]),
            factory(Week::class)->make([
                'starts_at' => $startTime->addWeek(1)
            ]),
            factory(Week::class)->make([
                'starts_at' => $startTime->addWeek(1)
            ]),
            factory(Week::class)->make([
                'starts_at' => $startTime->addWeek(1)
            ]),
        ]);

        $user1 = User::find($cycle->created_by);
        $user2 = factory(User::class)->create();
        $users = factory(User::class, 8)->create();

        $cycle->signups()->attach([
            $user1->id => [
                'div_pref_first'    => 'mens',
                'div_pref_second'   => 'mens',
                'will_captain'      => false,
            ],
            $user2->id => [
                'div_pref_first'    => 'mens',
                'div_pref_second'   => 'mens',
                'will_captain'      => false,
            ],
        ]);

        $cycle->weeks->each(function($week) use ($user1, $user2) {
            $user1->availability()->attach($week->id, [
                'attending' => true
            ]);
            $user2->availability()->attach($week->id, [
                'attending' => true
            ]);
        });

        $this->assertEquals(8, User::notSignedUpForCycle($cycle)->count());
        $this->assertFalse(User::notSignedUpForCycle($cycle)->contains($user2));
        $this->assertTrue(User::notSignedUpForCycle($cycle)->contains($users->get(4)));
    }

    /** @test */
    function can_apply_credit_rain_out_credit_for_a_given_week()
    {
        // can apply credit rain out credit for a given week

        // it can get a collection of its players (signups assigned to a team)
        $week = factory(Week::class)->states('rained-out')->create();

        $players = factory(User::class, 3)->create();

        $team = $week->cycle->teams()->save(factory(Team::class)->make());

        $week->cycle->signups()->attach($players->get(0)->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
            'team_id' => $team->id,
        ]);

        $week->cycle->signups()->attach($players->get(1)->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false
        ]);

        $week->cycle->signups()->attach($players->get(2)->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
            'team_id' => $team->id,
        ]);

        $players->each(function($player) use ($week) {
            $player->availability()->attach($week->id, [
                'attending' => true
            ]);
        });

        $players->get(0)->applyRainoutCredit($week);

        $this->assertTrue($players->get(0)->fresh()->credits->where('week_id', $week->id)->count() > 0);
    }

    /** @test */
    function can_determine_if_it_is_a_captain_of_a_given_cycle()
    {
        // can determine if it is a captain of a given cycle
        $cycle = factory(Cycle::class)->create([
            'signup_opens_at' => Carbon::now()->subMonths(2)
        ]);

        $team = $cycle->teams()->save(factory(Team::class)->make());
        $users = factory(User::class, 4)->create();
        // create 4 users, 2 are a captain, 2 are not
        $cycle->signups()->attach($users->get(0)->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
            'team_id'           => $team->id,
        ]);
        $cycle->signups()->attach($users->get(1)->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
            'team_id'           => $team->id
        ]);
        $cycle->signups()->attach($users->get(2)->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
            'team_id'           => $team->id,
            'captain'           => true,
        ]);
        $cycle->signups()->attach($users->get(3)->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
            'team_id'           => $team->id,
            'captain'           => true,
        ]);

        $this->assertFalse($users->get(0)->isCaptain($cycle));
        $this->assertTrue($users->get(3)->isCaptain($cycle));
    }

    /** @test */
    function can_determine_if_it_is_a_captain_of_the_current_cycle_if_one_is_not_given()
    {
        // can determine if it is a captain of the current cycle if one is not given
        $cycle = factory(Cycle::class)->create();

        $team = $cycle->teams()->save(factory(Team::class)->make());
        $users = factory(User::class, 4)->create();
        // create 4 users, 2 are a captain, 2 are not
        $cycle->signups()->attach($users->get(0)->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
            'team_id'           => $team->id,
        ]);
        $cycle->signups()->attach($users->get(1)->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
            'team_id'           => $team->id
        ]);
        $cycle->signups()->attach($users->get(2)->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
            'team_id'           => $team->id,
            'captain'           => true,
        ]);
        $cycle->signups()->attach($users->get(3)->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
            'team_id'           => $team->id,
            'captain'           => true,
        ]);

        $this->assertFalse($users->get(0)->isCaptain());
        $this->assertTrue($users->get(3)->isCaptain());
    }

    /** @test */
    function is_not_a_captain_if_there_is_no_current_cycle()
    {
        // is not a captain if there is no current cycle
        $cycle = factory(Cycle::class)->create([
            'signup_opens_at' => Carbon::now()->subMonths(2)
        ]);

        $team = $cycle->teams()->save(factory(Team::class)->make());
        $user = factory(User::class)->create();

        $cycle->signups()->attach($user->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
            'team_id'           => $team->id,
            'captain'           => true,
        ]);

        $this->assertFalse($user->isCaptain());
    }
}