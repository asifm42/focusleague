<?php

namespace Tests\Feature\Unit;

use App\Models\Cycle;
use App\Models\Team;
use App\Models\User;
use App\Models\Week;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class WeekTest extends TestCase
{
    /** @test */
    function mark_as_rained_out()
    {
        // $week = factory(Week::class)->states('withCycle')->create();
        $week = factory(Week::class)->create(['cycle_id' => 1]);

        $this->assertFalse($week->isRainedout());

        $week->markAsRainedOut();

        $this->assertTrue($week->fresh()->isRainedOut());
    }

    /** @test */
    function it_can_update_its_status()
    {
        // it_can_update_its_status
        $week = factory(Week::class)->create(['cycle_id' => 1, 'status' => null]);

        $this->assertNull($week->status);

        $week->updateStatus('Game OFF');

        $this->assertEquals('Game OFF', $week->fresh()->status);
    }

    /** @test */
    function it_can_get_a_collection_of_its_players()
    {
        // it can get a collection of its players (signups assigned to a team)
        $week = factory(Week::class)->create();

        $players = factory(User::class, 4)->create();

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

        $week->cycle->signups()->attach($players->get(3)->id, [
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

        $players->get(3)->availability()->updateExistingPivot($week->id, [
                'attending' => false
            ]);

        $this->assertEquals(2, $week->players()->count());
        $this->assertTrue($week->players()->contains($players->get(0)));
        $this->assertFalse($week->players()->contains($players->get(1)));
        $this->assertTrue($week->players()->contains($players->get(2)));
        $this->assertFalse($week->players()->contains($players->get(3)));
    }

    /** @test */
    function it_can_get_a_collection_of_its_subs_assigned_to_a_team()
    {
        // it can get a collection of its subs assigned to a team
        $week = factory(Week::class)->create();

        $players = factory(User::class, 4)->create();

        $team = $week->cycle->teams()->save(factory(Team::class)->make());

        $week->subs()->attach($players->get(0)->id, ['team_id' => $team->id]);
        $week->subs()->attach($players->get(1)->id);
        $week->subs()->attach($players->get(2)->id);

        $this->assertEquals(3, $week->fresh()->subs->count());
        $this->assertEquals(1, $week->fresh()->subsOnATeam->count());
    }
}