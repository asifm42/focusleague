<?php

namespace Tests\Browser;

use App\Models\Cycle;
use App\Models\UltimateHistory;
use App\Models\User;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Helpers\DatabaseSetup;

class CycleTest extends DuskTestCase
{
    use DatabaseMigrations, DatabaseSetup;

    public function setup()
    {
        parent::setup();
        $this->setupDatabase();
    }

    /** @test */
    public function user_can_see_cycle_listing()
    {
        $user = factory(User::class)->create();
        $cycle = factory(Cycle::class)->create()->addWeeks(4);

        $this->browse(function (Browser $browser) use ($user, $cycle) {
            $browser->loginAs($user)
                    ->visit('/cycles/'.$cycle->id)
                    ->assertSee('Cycle 2016-01');
        });
    }
}
