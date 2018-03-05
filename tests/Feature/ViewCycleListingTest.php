<?php

namespace Tests\Feature;

use App\Models\Cycle;
use App\Models\UltimateHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ViewCycleListingTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function user_can_view_a_cycle()
    {
        // $this->disableExceptionHandling();
        $cycles = factory(Cycle::class, 4)->create();
        $cycle = Cycle::find(2);

        $user = factory(User::class)->create();
        $user->ultimateHistory()->save(factory(UltimateHistory::class)->make());

        $this->assertNotNull($cycle);

        $response = $this->actingAs($user)->get('/cycles/' . $cycle->id);

        $response->assertStatus(200);
    }
}