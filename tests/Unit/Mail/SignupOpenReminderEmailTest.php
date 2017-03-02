<?php

namespace Tests\Feature;

use App\Mail\SignupOpenReminderEmail;
use App\Mailers\UserMailer;
use App\Models\Cycle;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SignupOpenReminderEmailTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function signup_closing_reminder_email_is_being_sent()
    {
        Mail::fake();

        $mailer = new UserMailer;
        $cycle = factory(Cycle::class)->create();
        $user = factory(User::class)->create();

        $mailer->sendSignupOpenReminderEmail($user,$cycle);

        Mail::assertSent(SignupOpenReminderEmail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /** @test */
    function the_view_is_being_generated_with_no_errors()
    {
        $mailer = new UserMailer;
        $cycle = factory(Cycle::class)->create();
        $user = factory(User::class)->create();

        $mailer->sendSignupOpenReminderEmail($user,$cycle);
        $this->assertTrue(true);
    }
}