<?php

namespace Tests\Unit\Mail;

use App\Mail\WelcomeEmail;
use App\Mailers\UserMailer;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class WelcomeEmailTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function welcome_email_is_being_sent()
    {
        Mail::fake();
        $mailer = new UserMailer;
        $mailer->sendWelcomeEmail($user = factory(User::class)->create());

        Mail::assertSent(WelcomeEmail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /** @test */
    function the_view_is_being_generated_with_no_errors()
    {
        $mailer = new UserMailer;
        $mailer->sendWelcomeEmail(factory(User::class)->create());
        $this->assertTrue(true);
    }
}