<?php

namespace Tests\Feature;

use App\Models\Cycle;
use App\Models\UltimateHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CaptainDashboardTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function captain_can_view_captain_dashboard()
    {
        $this->disableExceptionHandling();
        $cycles = factory(Cycle::class, 4)->create();
        $cycle = Cycle::find(2);

        $captain = factory(User::class)->create();
        $captain->ultimateHistory()->save(factory(UltimateHistory::class)->make());

        $this->assertNotNull($cycle);

        $response = $this->actingAs($captain)->get('/captains/dashboard');

        $response->assertStatus(200);
    }

    /** @test */
    function admin_can_view_captain_dashboard()
    {

    }

    /** @test */
    function normal_user_can_not_view_captain_dashboard()
    {

    }
}