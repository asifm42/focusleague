<?php

namespace Tests\Feature;

use App\Models\Cycle;
use App\Models\Team;
use App\Models\User;
use App\Models\Week;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function can_return_its_name_and_division()
    {
        $team = factory(Team::class)->make();

        $this->assertEquals(ucwords($team->name) . ' (' . ucwords($team->division) . ')', $team->nameAndDivision());
    }

    /** @test */
    function team_can_add_a_player()
    {
        $cycle = factory(Cycle::class)->create();
        $startTime = $cycle->starts_at;
        $cycle->weeks()->saveMany([
            factory(Week::class)->make([
                'cycle_id' => $cycle->id,
                'starts_at' => $startTime
            ]),
            factory(Week::class)->make([
                'cycle_id' => $cycle->id,
                'starts_at' => $startTime->addWeek(1)
            ]),
            factory(Week::class)->make([
                'cycle_id' => $cycle->id,
                'starts_at' => $startTime->addWeek(1)
            ]),
            factory(Week::class)->make([
                'cycle_id' => $cycle->id,
                'starts_at' => $startTime->addWeek(1)
            ]),
        ]);

        $user1 = User::find($cycle->created_by);
        $user2 = factory(User::class)->create();
        $users = factory(User::class, 8)->create();

        $teams = $cycle->teams()->saveMany(factory(Team::class, 4)->make());

        $cycle->signups()->attach($user1->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
        ]);

        $cycle->weeks->each(function($week) use ($user1) {
            $user1->availability()->attach($week->id, [
                'attending' => true
            ]);
        });

        $team1 = $teams->get(0)->fresh();
        $team1->addPlayer($user1);

        $this->assertTrue($team1->fresh()->players->contains($user1));
    }
}
