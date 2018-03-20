<?php

namespace Tests\Feature;

use App\Models\Cycle;
use App\Models\UltimateHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ViewCurrentCycleListingTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function user_can_view_a_current_cycle()
    {
        // $this->disableExceptionHandling();
        $cycle = factory(Cycle::class)->create();

        $user = factory(User::class)->create();
        $user->ultimateHistory()->save(factory(UltimateHistory::class)->make());

        $this->assertNotNull($cycle);

        $response = $this->actingAs($user)->get('/cycles/current');

        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/cycles/' . $cycle->id);

        $response->assertStatus(200);
    }

    /** @test */
    function user_is_redirected_to_cycle_index_page_when_there_is_no_current_cycle()
    {
        // $this->disableExceptionHandling();
        $user = factory(User::class)->create();
        $user->ultimateHistory()->save(factory(UltimateHistory::class)->make());

        $this->assertNull(Cycle::currentCycle());

        $response = $this->actingAs($user)->get('/cycles/current');

        $response->assertStatus(302);

        $response->assertSessionHas('flash_notification.message', $value = 'Sorry, there is no current cycle at the moment.');
        $response->assertSessionHas('flash_notification.level', $value = 'info');
    }

    /**
     * @test
     * @expectedException App\Exceptions\NoCurrentCycleException
    */
    function an_exception_is_thrown_when_there_is_no_current_cycle()
    {
        $this->disableExceptionHandling();
        $user = factory(User::class)->create();
        $user->ultimateHistory()->save(factory(UltimateHistory::class)->make());

        $this->assertNull(Cycle::currentCycle());

        $response = $this->actingAs($user)->get('/cycles/current');
    }
}