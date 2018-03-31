<?php

namespace Tests\Unit;

use App\Models\Cycle;
use App\Models\Team;
use App\Models\User;
use App\Models\Week;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CycleTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function can_get_current_cycle()
    {
        if(Carbon::now()->dayOfWeek == Carbon::WEDNESDAY) {
            $signupOpen = Carbon::today();
        } else {
            $signupOpen = new Carbon('last wednesday');
        };

        $wayPastCycle = factory(Cycle::class)->create([
            'signup_opens_at' => $signupOpen->copy()->subWeeks(9),
            'name' => '2017-01'
        ]);

        $pastCycle = factory(Cycle::class)->create([
            'signup_opens_at' => $signupOpen->copy()->subWeeks(5),
            'name' => '2017-02'
        ]);

        $currentCycle = factory(Cycle::class)->create([
            'name' => '2017-03'
        ]);

        $futureCycle = factory(Cycle::class)->create([
            'signup_opens_at' => $currentCycle->ends_at->addDays(1)->startOfDay(),
            'name' => '2017-04'
        ]);

        $this->assertEquals($currentCycle->id, Cycle::currentCycle()->id);
    }

    /** @test */
    function can_get_list_of_signups()
    {
        $cycle = factory(Cycle::class)->create()->addWeeks(4);

        $user1 = User::find($cycle->created_by);
        $user2 = factory(User::class)->create();
        $user3 = factory(User::class)->create();
        $user4 = factory(User::class)->create();
        $user5 = factory(User::class)->create();

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
            $user3->id => [
                'div_pref_first'    => 'mens',
                'div_pref_second'   => 'mens',
                'will_captain'      => false,
            ],
        ]);

        // $cycle->weeks->each(function($week) use ($user1) {
        //     $user1->availability()->attach($week->id, [
        //         'attending' => true
        //     ]);
        // });

        // do we need add availability for the other signups

        $this->assertEquals(3, $cycle->signups->count());
        $this->assertTrue($cycle->signups->contains($user2));
        $this->assertTrue($cycle->signups->contains($user3));
        $this->assertFalse($cycle->signups->contains($user4));
        $this->assertFalse($cycle->signups->contains($user5));
    }

    /** @test */
    function can_get_list_of_users_not_signed_up()
    {
        $cycle = factory(Cycle::class)->create()->addWeeks(4);

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

        $this->assertEquals(8, $cycle->usersNotSignedUp()->count());
        $this->assertFalse($cycle->usersNotSignedUp()->contains($user2));
        $this->assertTrue($cycle->usersNotSignedUp()->contains($users->get(4)));
    }

    /** @test */
    function can_add_a_week_to_a_cycle_with_no_weeks()
    {
        $cycle = factory(Cycle::class)->create();
        $this->assertEquals(0, $cycle->weeks->count());

        $cycle = $cycle->addWeek();

        $this->assertEquals(1, $cycle->weeks->count());
        $this->assertEquals($cycle->starts_at, $cycle->weeks->get(0)->starts_at);
        $this->assertEquals($cycle->weeks->get(0)->starts_at->addHours(2), $cycle->weeks->get(0)->ends_at);
        $this->assertEquals($cycle->weeks->last()->ends_at->endOfDay(), $cycle->ends_at);
    }

    /** @test */
    function can_add_a_week_to_a_cycle_with_existing_weeks()
    {
        $cycle = factory(Cycle::class)->create()->addWeek();
        $this->assertEquals(1, $cycle->weeks->count());
        $this->assertEquals($cycle->starts_at, $cycle->weeks->get(0)->starts_at);

        $cycle = $cycle->addWeek();

        $this->assertEquals(2, $cycle->weeks->count());
        $this->assertEquals($cycle->weeks->last()->starts_at, $cycle->weeks->first()->starts_at->addWeek(1));
        $this->assertEquals($cycle->weeks->last()->starts_at->addHours(2), $cycle->weeks->last()->ends_at);
        $this->assertEquals($cycle->weeks->last()->ends_at->endOfDay(), $cycle->ends_at);
    }

    /** @test */
    function can_add_multiple_weeks_to_a_cycle_with_no_weeks()
    {
        $cycle = factory(Cycle::class)->create();
        $this->assertEquals(0, $cycle->weeks->count());

        $cycle = $cycle->addWeeks(3);

        $this->assertEquals(3, $cycle->weeks->count());
        $this->assertEquals($cycle->starts_at, $cycle->weeks->get(0)->starts_at);
        $this->assertEquals($cycle->starts_at->copy()->addWeek(1), $cycle->weeks->get(1)->starts_at);
        $this->assertEquals($cycle->starts_at->copy()->addWeek(2), $cycle->weeks->get(2)->starts_at);
        $this->assertEquals($cycle->weeks->last()->ends_at->endOfDay(), $cycle->ends_at);
    }

    /** @test */
    function can_add_multiple_weeks_to_a_cycle_with_existing_weeks()
    {
        $cycle = factory(Cycle::class)->create()->addWeek();
        $this->assertEquals(1, $cycle->weeks->count());

        $cycle = $cycle->addWeeks(3);

        $this->assertEquals(4, $cycle->weeks->count());
        $this->assertEquals($cycle->starts_at, $cycle->weeks->get(0)->starts_at);
        $this->assertEquals($cycle->starts_at->copy()->addWeek(1), $cycle->weeks->get(1)->starts_at);
        $this->assertEquals($cycle->starts_at->copy()->addWeek(2), $cycle->weeks->get(2)->starts_at);
        $this->assertEquals($cycle->starts_at->copy()->addWeek(3), $cycle->weeks->get(3)->starts_at);
        $this->assertEquals($cycle->weeks->last()->ends_at->endOfDay(), $cycle->ends_at);
    }

    /** @test */
    function can_get_a_list_of_signups_not_on_a_team()
    {
        $cycle = factory(Cycle::class)->create();
        $team = $cycle->teams()->save(factory(Team::class)->make());
        $users = factory(User::class, 4)->create();
        // create 4 users, 2 on a team, 2 not on a team
        $cycle->signups()->attach($users->get(0)->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
        ]);
        $cycle->signups()->attach($users->get(1)->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
        ]);
        $cycle->signups()->attach($users->get(2)->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
            'team_id'           => $team->id
        ]);
        $cycle->signups()->attach($users->get(3)->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
            'team_id'           => $team->id
        ]);

        $this->assertTrue($cycle->signupsNotOnATeam()->contains($users->get(0)));
        $this->assertTrue($cycle->signupsNotOnATeam()->contains($users->get(1)));
        $this->assertFalse($cycle->signupsNotOnATeam()->contains($users->get(2)));
        $this->assertFalse($cycle->signupsNotOnATeam()->contains($users->get(3)));
    }

    /** @test */
    function can_get_a_list_of_signups_on_a_team()
    {
        $cycle = factory(Cycle::class)->create();

        $team = $cycle->teams()->save(factory(Team::class)->make());
        $users = factory(User::class, 4)->create();
        // create 4 users, 2 on a team, 2 not on a team
        $cycle->signups()->attach($users->get(0)->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
        ]);
        $cycle->signups()->attach($users->get(1)->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
        ]);
        $cycle->signups()->attach($users->get(2)->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
            'team_id'           => $team->id
        ]);
        $cycle->signups()->attach($users->get(3)->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
            'team_id'           => $team->id
        ]);

        $this->assertFalse($cycle->signupsOnATeam()->contains($users->get(0)));
        $this->assertFalse($cycle->signupsOnATeam()->contains($users->get(1)));
        $this->assertTrue($cycle->signupsOnATeam()->contains($users->get(2)));
        $this->assertTrue($cycle->signupsOnATeam()->contains($users->get(3)));
    }

    /** @test */
    function can_find_a_cycle_by_name()
    {
        $cycle01 = factory(Cycle::class)->create(['name'=>'2017-04']);
        $cycle02 = factory(Cycle::class)->create(['name'=>'2017-10']);

        $this->assertEquals($cycle01->id, Cycle::findByName('2017-04')->id);
        $this->assertEquals($cycle02->id, Cycle::findByName('2017-10')->id);
        $this->assertNull(Cycle::findByName('2017-06'));
    }

    /** @test */
    function can_determine_if_a_given_user_is_subbing_that_cycle()
    {
        // can see if a user is subbing that cycle
        // a cycle with 3 weeks
        $cycle = factory(Cycle::class)->create()->addWeeks(3);

        // a user that will be subbing the second week
        $sub = factory(User::class)->create();

        // a user not subbing
        $user = factory(User::class)->create();

        // test that each function is false for each user
        $this->assertFalse($cycle->isSubbing($sub));
        $this->assertFalse($cycle->isSubbing($user));

        // add first user to sub second week of cycle
        $cycle->weeks->find(2)->subs()->attach($sub->id);

        // test that first user is true for function
        $this->assertTrue($cycle->fresh()->isSubbing($sub));

        // test that second user is false for funciton
        $this->assertFalse($cycle->fresh()->isSubbing($user));
    }
}