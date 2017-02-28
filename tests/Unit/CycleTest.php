<?php

namespace Tests\Unit;

use App\Models\Cycle;
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
}