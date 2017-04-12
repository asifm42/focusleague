<?php

namespace Tests\Unit\Notification;

use App\Models\Cycle;
use App\Models\User;
use App\Models\Week;
use App\Notifications\Rainout;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RainoutNotificationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function rainout_notification_is_being_sent()
    {
        Notification::fake();
        $user = factory(User::class)->create();
        $cycle = factory(Cycle::class)->create()->addWeeks(4);
        $week = $cycle->weeks->get(0);
        $user->notify(new Rainout($week));

        Notification::assertSentTo(
            [$user], Rainout::class
        );
    }

    /** @test */
    function the_view_is_being_generated_with_no_errors()
    {
        $user = factory(User::class)->create();
        $cycle = factory(Cycle::class)->create()->addWeeks(4);
        $week = $cycle->weeks->get(0);
        $user->notify(new Rainout($week));
        $this->assertTrue(true);
    }
}
