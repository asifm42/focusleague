<?php

namespace Tests\Unit\Mail;

use App\Mail\SubSignupConfirmation;
use App\Mailers\UserMailer;
use App\Models\Cycle;
use App\Models\Sub;
use App\Models\User;
use App\Models\Week;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SubSignupConfirmationEmailTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function sub_signup_confirmation_email_is_being_sent()
    {
        Mail::fake();

        $mailer = new UserMailer;
        $cycle = factory(Cycle::class)->create();
        $user = factory(User::class)->create();

        // add weeks for cycle
        $startTime = $cycle->starts_at;
        $cycle->weeks()->saveMany([
            factory(Week::class)->make([
                'starts_at' => $startTime
            ]),
            factory(Week::class)->make([
                'starts_at' => $startTime->addWeek(1)
            ]),
            factory(Week::class)->make([
                'starts_at' => $startTime->addWeek(1)
            ]),
            factory(Week::class)->make([
                'starts_at' => $startTime->addWeek(1)
            ]),
        ]);

        $cycle->weeks->get(1)->subs()->attach($user->id, [
            'note'=>""
        ]);

        $sub = Sub::findOrFail($cycle->weeks->get(1)->subs()->where('user_id', $user->id)->first()->pivot->id);

        $mailer->sendSubSignupConfirmationEmail($sub);

        Mail::assertSent(SubSignupConfirmation::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /** @test */
    function the_view_is_being_generated_with_no_errors()
    {
        $mailer = new UserMailer;
        $cycle = factory(Cycle::class)->create();
        $user = factory(User::class)->create();

        // add weeks for cycle
        $startTime = $cycle->starts_at;
        $cycle->weeks()->saveMany([
            factory(Week::class)->make([
                'starts_at' => $startTime
            ]),
            factory(Week::class)->make([
                'starts_at' => $startTime->addWeek(1)
            ]),
            factory(Week::class)->make([
                'starts_at' => $startTime->addWeek(1)
            ]),
            factory(Week::class)->make([
                'starts_at' => $startTime->addWeek(1)
            ]),
        ]);

        $cycle->weeks->get(1)->subs()->attach($user->id, [
            'note'=>""
        ]);

        $sub = Sub::findOrFail($cycle->weeks->get(1)->subs()->where('user_id', $user->id)->first()->pivot->id);

        $mailer->sendSubSignupConfirmationEmail($sub);
        $this->assertTrue(true);
    }
}