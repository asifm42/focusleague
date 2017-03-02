<?php

namespace Tests\Unit\Email;

use App\Mail\SignupClosingReminderEmail;
use App\Mailers\UserMailer;
use App\Models\Cycle;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SignupClosingReminderEmailTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function signup_closing_reminder_email_is_being_sent()
    {
        Mail::fake();

        $mailer = new UserMailer;
        $cycle = factory(Cycle::class)->create();
        $user = factory(User::class)->create();

        $mailer->sendSignupClosingReminderEmail($user,$cycle);

        Mail::assertSent(SignupClosingReminderEmail::class, function ($mail) use ($user, $cycle) {
            return $mail->hasTo($user->email);
        });
    }

    /** @test */
    function the_view_is_being_generated_with_no_errors()
    {
        $mailer = new UserMailer;
        $cycle = factory(Cycle::class)->create();
        $user = factory(User::class)->create();

        $mailer->sendSignupClosingReminderEmail($user,$cycle);
        $this->assertTrue(true);
    }
}