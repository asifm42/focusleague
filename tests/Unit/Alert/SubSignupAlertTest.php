<?php

namespace Tests\Unit\Alert;

use App\Mail\Alert\SubSignupAlert;
use App\Mailers\AlertMailer;
use App\Models\Cycle;
use App\Models\Sub;
use App\Models\User;
use App\Models\Week;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SubSignupAlertTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function sub_signup_alert_is_being_sent()
    {
        Mail::fake();

        $mailer = new AlertMailer;
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

        $mailer->sendSubSignUpAlert($sub);

        Mail::assertSent(SubSignupAlert::class, function ($mail) {
            return $mail->hasTo('asifm42@gmail.com') &&
                    $mail->hasCc('gizmolito@gmail.com');
        });
    }

    /** @test */
    function the_view_is_being_generated_with_no_errors()
    {
        $mailer = new AlertMailer;
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

        $mailer->sendSubSignUpAlert($sub);
        $this->assertTrue(true);
    }
}