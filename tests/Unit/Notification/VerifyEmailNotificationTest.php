<?php

namespace Tests\Unit\Notification;

use App\Notifications\VerifyEmail;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class VerifyEmailNotificationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function verify_email_notification_is_being_sent()
    {
        Notification::fake();
        $user = factory(User::class)->create();
        $user->notify(new VerifyEmail());

        Notification::assertSentTo(
            [$user], VerifyEmail::class
        );
    }

    /** @test */
    function the_view_is_being_generated_with_no_errors()
    {
        $user = factory(User::class)->create();
        $user->notify(new VerifyEmail());
        $this->assertTrue(true);
    }
}
