<?php

namespace Tests\Unit\Mail;

use App\Mail\SignupClosedEmail;
use App\Mailers\UserMailer;
use App\Models\Cycle;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SignupClosedEmailTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function signup_closed_announcement_email_is_being_sent()
    {
        Mail::fake();

        $mailer = new UserMailer;
        $cycle = factory(Cycle::class)->create();
        $user = factory(User::class)->create();

        $mailer->sendSignUpClosedEmail($user,$cycle);

        Mail::assertSent(SignupClosedEmail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /** @test */
    function the_view_is_being_generated_with_no_errors()
    {
        $mailer = new UserMailer;
        $cycle = factory(Cycle::class)->create();
        $user = factory(User::class)->create();

        $mailer->sendSignUpClosedEmail($user,$cycle);
        $this->assertTrue(true);
    }
}