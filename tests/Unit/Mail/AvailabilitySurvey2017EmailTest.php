<?php

namespace Tests\Unit\Mail;

use App\Mail\AvailabilitySurvey2017Email;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AvailabilitySurvey2017EmailTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function availability_survey_email_is_being_sent()
    {
        Mail::fake();

        $user = factory(User::class)->create();

        Mail::to($user)->send(new AvailabilitySurvey2017Email($user));

        Mail::assertSent(AvailabilitySurvey2017Email::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /** @test */
    function the_view_is_being_generated_with_no_errors()
    {
        $user = factory(User::class)->create();

        Mail::to($user)->send(new AvailabilitySurvey2017Email($user));
        $this->assertTrue(true);
    }
}