<?php

namespace Tests\Unit\Mail;

use App\Mail\Alert\NewUserRegisteredAlert;
use App\Mailers\AlertMailer;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class NewUserRegisteredAlertTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function cycle_signup_confirmation_email_is_being_sent()
    {
        Mail::fake();

        $mailer = new AlertMailer;

        $mailer->sendNewUserRegisteredAlert(factory(User::class)->create());

        Mail::assertSent(NewUserRegisteredAlert::class, function ($mail) {
            return $mail->hasTo('asifm42@gmail.com');
        });
    }

    /** @test */
    function the_view_is_being_generated_with_no_errors()
    {
        $mailer = new AlertMailer;

        $mailer->sendNewUserRegisteredAlert(factory(User::class)->create());
        $this->assertTrue(true);
    }
}