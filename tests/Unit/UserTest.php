<?php

namespace Tests\Unit;

use App\Models\Cycle;
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
    function can_get_list_of_users_not_signed_up_for_a_give_cycle()
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
}