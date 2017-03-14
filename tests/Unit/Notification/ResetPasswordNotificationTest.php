<?php

namespace Tests\Unit\Notification;

use App\Notifications\ResetPassword;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ResetPasswordNotificationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function reset_password_notification_is_being_sent()
    {
        Notification::fake();
        $user = factory(User::class)->create();
        $user->notify(new ResetPassword('token'));

        Notification::assertSentTo(
            [$user], ResetPassword::class
        );
    }

    /** @test */
    function the_view_is_being_generated_with_no_errors()
    {
        $user = factory(User::class)->create();
        $user->notify(new ResetPassword('token'));
        $this->assertTrue(true);
    }
}
