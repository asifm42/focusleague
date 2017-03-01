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
        $user3 = factory(User::class)->create();
        $user4 = factory(User::class)->create();
        $user5 = factory(User::class)->create();

        $cycle->signups()->attach($user1->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
        ]);


        $cycle->signups()->attach($user2->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
        ]);
        $cycle->signups()->attach($user3->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
        ]);

        $cycle->weeks->each(function($week) use ($user1) {
            $user1->availability()->attach($week->id, [
                'attending' => true
            ]);
        });

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

        $this->assertEquals(9, $cycle->usersNotSignedUp()->count());
        $this->assertTrue($cycle->usersNotSignedUp()->contains($user2));
        $this->assertTrue($cycle->usersNotSignedUp()->contains($users->get(4)));
    }
}