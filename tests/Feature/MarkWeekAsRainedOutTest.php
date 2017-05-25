<?php

namespace Tests\Feature;

use App\Models\Cycle;
use App\Models\Team;
use App\Models\User;
use App\Models\Week;
use App\Notifications\Rainout;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class MarkWeekAsRainedOutTest extends TestCase
{
    /** @test */
    function admin_can_mark_a_week_as_rained_out()
    {
        // admin_can_mark_a_week_as_rained_out

        Notification::fake();

        // create admin
        $admin = factory(User::class)->states('admin')->create();

        // create a cycle with 4 weeks
        $cycle = factory(Cycle::class)->create([
            'created_by' => $admin->id
        ])->addWeeks(4);

        // create 1 player
        $player = factory(User::class)->create();

        $team = $cycle->teams()->save(factory(Team::class)->make());

        $cycle->signups()->attach($player->id, [
                'div_pref_first'    => 'mens',
                'div_pref_second'   => 'mens',
                'will_captain'      => false,
                'team_id'           => $team->id
            ]);

        // add player availability
        $cycle->weeks->each(function($week) use ($player) {
            $player->availability()->attach($week->id, [
                'attending' => true
            ]);
        });

        $week = $cycle->weeks->get(2);

        $this->assertEquals(1, Cycle::count());
        $this->assertEquals(4, Week::count());
        $this->assertEquals(2, User::count());

        $response = $this->actingAs($admin)->post('/weeks/' . $week->id . '/rainout', [
            'rained_out' => true,
            'status' => 'Game OFF'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/weeks/' . $week->id);

        // get a fresh week;
        $week = $week->fresh();

        // week should be rained out
        $this->assertTrue($week->isRainedOut());

        // week should have status
        $this->assertEquals('Game OFF', $week->status);

        // status displayed on front page

        // db has record
        $this->assertDatabaseHas('transactions', [
             'week_id' => $week->id,
             'user_id' => $player->id,
             'cycle_id' => $week->cycle->id,
             'amount'    => 5.00,
             'type' =>   'credit',
             'description' => 'Rainout credit'
        ]);

        // players is notified
        Notification::assertSentTo(
            [$player], Rainout::class
        );

    }

    /** @test */
    function attending_players_receive_a_5_dollar_credit_for_when_a_week_is_rained_out()
    {
        // attending players receive a credit for when a week is rained out

        Notification::fake();

        // create admin
        $admin = factory(User::class)->states('admin')->create();

        // create a cycle with 4 weeks
        $cycle = factory(Cycle::class)->create([
            'created_by' => $admin->id
        ])->addWeeks(4);

        // create 1 player
        $player = factory(User::class)->create();

        $team = $cycle->teams()->save(factory(Team::class)->make());

        $cycle->signups()->attach($player->id, [
                'div_pref_first'    => 'mens',
                'div_pref_second'   => 'mens',
                'will_captain'      => false,
                'team_id'           => $team->id
            ]);

        // add player availability
        $cycle->weeks->each(function($week) use ($player) {
            $player->availability()->attach($week->id, [
                'attending' => true
            ]);
        });

        $week = $cycle->weeks->get(2);

        $this->assertEquals(1, Cycle::count());
        $this->assertEquals(4, Week::count());
        $this->assertEquals(2, User::count());

        $response = $this->actingAs($admin)->post('/weeks/' . $week->id . '/rainout', [
            'rained_out' => true,
            'status' => 'Game OFF'
        ]);

        $response->assertStatus(200);

        // get a fresh week;
        $week = $week->fresh();

        // db has record
        $this->assertDatabaseHas('transactions', [
             'week_id' => $week->id,
             'user_id' => $player->id,
             'cycle_id' => $week->cycle->id,
             'amount'    => 5.00,
             'type' =>   'credit',
             'description' => 'Rainout credit'
        ]);

        // players is notified
        Notification::assertSentTo(
            [$player], Rainout::class
        );
    }

    /** @test */
    function non_attending_players_do_not_receive_a_credit_for_when_a_week_is_rained_out()
    {
        // attending players receive a credit for when a week is rained out

        Notification::fake();

        // create admin
        $admin = factory(User::class)->states('admin')->create();

        // create a cycle with 4 weeks
        $cycle = factory(Cycle::class)->create([
            'created_by' => $admin->id
        ])->addWeeks(4);

        // create 1 player
        $player = factory(User::class)->create();

        $team = $cycle->teams()->save(factory(Team::class)->make());

        $cycle->signups()->attach($player->id, [
                'div_pref_first'    => 'mens',
                'div_pref_second'   => 'mens',
                'will_captain'      => false,
                'team_id'           => $team->id
            ]);

        // add player availability
        $cycle->weeks->each(function($week) use ($player) {
            $player->availability()->attach($week->id, [
                'attending' => true
            ]);
        });

        $week = $cycle->weeks->get(2);
        $player->availability()->updateExistingPivot($week->id, [
            'attending' => false
        ]);


        $this->assertEquals(1, Cycle::count());
        $this->assertEquals(4, Week::count());
        $this->assertEquals(2, User::count());

        $response = $this->actingAs($admin)->post('/weeks/' . $week->id . '/rainout', [
            'rained_out' => true,
            'status' => 'Game OFF'
        ]);

        $response->assertStatus(200);

        // get a fresh week;
        $week = $week->fresh();

        // No db record
        $this->assertDatabaseMissing('transactions', [
             'week_id' => $week->id,
             'user_id' => $player->id,
             'cycle_id' => $week->cycle->id,
             'type' =>   'credit',
        ]);

        // player is not notified
        Notification::assertNotSentTo(
            [$player], Rainout::class
        );
    }

    /** @test */
    function attending_captains_receive_a_discounted_credit_for_when_a_week_is_rained_out()
    {
        // attending players receive a credit for when a week is rained out

        Notification::fake();

        // create admin
        $admin = factory(User::class)->states('admin')->create();

        // create a cycle with 4 weeks
        $cycle = factory(Cycle::class)->create([
            'created_by' => $admin->id
        ])->addWeeks(4);

        // create 1 player
        $player = factory(User::class)->create();

        $team = $cycle->teams()->save(factory(Team::class)->make());

        $cycle->signups()->attach($player->id, [
                'div_pref_first'    => 'mens',
                'div_pref_second'   => 'mens',
                'will_captain'      => false,
                'team_id'           => $team->id,
                'captain'           => true
            ]);

        // add player availability
        $cycle->weeks->each(function($week) use ($player) {
            $player->availability()->attach($week->id, [
                'attending' => true
            ]);
        });

        $week = $cycle->weeks->get(2);

        $this->assertEquals(1, Cycle::count());
        $this->assertEquals(4, Week::count());
        $this->assertEquals(2, User::count());

        $response = $this->actingAs($admin)->post('/weeks/' . $week->id . '/rainout', [
            'rained_out' => true,
            'status' => 'Game OFF'
        ]);

        $response->assertStatus(200);

        // get a fresh week;
        $week = $week->fresh();

        // db has record
        $this->assertDatabaseHas('transactions', [
             'week_id' => $week->id,
             'user_id' => $player->id,
             'cycle_id' => $week->cycle->id,
             'amount'    => 3.75,
             'type' =>   'credit',
             'description' => 'Rainout captain credit'
        ]);

        // player is notified
        Notification::assertSentTo(
            [$player], Rainout::class
        );
    }

    /** @test */
    function non_attending_captains_do_not_receive_a_credit_for_when_a_week_is_rained_out()
    {
        Notification::fake();

        // create admin
        $admin = factory(User::class)->states('admin')->create();

        // create a cycle with 4 weeks
        $cycle = factory(Cycle::class)->create([
            'created_by' => $admin->id
        ])->addWeeks(4);

        // create 1 player
        $player = factory(User::class)->create();

        $team = $cycle->teams()->save(factory(Team::class)->make());

        $cycle->signups()->attach($player->id, [
                'div_pref_first'    => 'mens',
                'div_pref_second'   => 'mens',
                'will_captain'      => false,
                'team_id'           => $team->id,
                'captain'           => true
            ]);

        // add player availability
        $cycle->weeks->each(function($week) use ($player) {
            $player->availability()->attach($week->id, [
                'attending' => true
            ]);
        });

        $week = $cycle->weeks->get(2);
        $player->availability()->updateExistingPivot($week->id, [
            'attending' => false
        ]);

        $this->assertEquals(1, Cycle::count());
        $this->assertEquals(4, Week::count());
        $this->assertEquals(2, User::count());

        $response = $this->actingAs($admin)->post('/weeks/' . $week->id . '/rainout', [
            'rained_out' => true,
            'status' => 'Game OFF'
        ]);

        $response->assertStatus(200);

        // get a fresh week;
        $week = $week->fresh();

        // No db record
        $this->assertDatabaseMissing('transactions', [
             'week_id' => $week->id,
             'user_id' => $player->id,
             'cycle_id' => $week->cycle->id,
             'type' =>   'credit',
        ]);

        // players is not notified
        Notification::assertNotSentTo(
            [$player], Rainout::class
        );
    }

    /** @test */
    function subs_on_a_team_receive_a_10_dollar_credit()
    {
        Notification::fake();

        // create admin
        $admin = factory(User::class)->states('admin')->create();

        // create a cycle with 4 weeks
        $cycle = factory(Cycle::class)->create([
            'created_by' => $admin->id
        ])->addWeeks(4);

        // create 1 player
        $sub = factory(User::class)->create();

        $team = $cycle->teams()->save(factory(Team::class)->make());

        // it can get a collection of its subs assigned to a team
        $week = $cycle->weeks->get(2);

        $week->subs()->attach($sub->id, ['team_id' => $team->id]);

        $response = $this->actingAs($admin)->post('/weeks/' . $week->id . '/rainout', [
            'rained_out' => true,
            'status' => 'Game OFF'
        ]);

        $response->assertStatus(200);

        // db has record
        $this->assertDatabaseHas('transactions', [
             'week_id' => $week->id,
             'user_id' => $sub->id,
             'cycle_id' => $week->cycle->id,
             'amount'    => 10,
             'type' =>   'credit',
             'description' => 'Rainout sub credit'
        ]);

        Notification::assertSentTo(
            [$sub], Rainout::class
        );
    }

    /** @test */
    function subs_not_on_a_team_are_not_credited()
    {
        Notification::fake();

        // create admin
        $admin = factory(User::class)->states('admin')->create();

        // create a cycle with 4 weeks
        $cycle = factory(Cycle::class)->create([
            'created_by' => $admin->id
        ])->addWeeks(4);

        // create 1 player
        $sub = factory(User::class)->create();

        $team = $cycle->teams()->save(factory(Team::class)->make());

        // it can get a collection of its subs assigned to a team
        $week = $cycle->weeks->get(2);

        $week->subs()->attach($sub->id);

        $response = $this->actingAs($admin)->post('/weeks/' . $week->id . '/rainout', [
            'rained_out' => true,
            'status' => 'Game OFF'
        ]);

        $response->assertStatus(200);

        // No db record
        $this->assertDatabaseMissing('transactions', [
             'week_id' => $week->id,
             'user_id' => $sub->id,
             'cycle_id' => $week->cycle->id,
             'type' =>   'credit',
        ]);

        Notification::assertNotSentTo(
            [$sub], Rainout::class
        );
    }
}