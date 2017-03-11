<?php

namespace Tests\Unit\Mail;

use App\Mail\CycleSignupConfirmation;
use App\Mailers\UserMailer;
use App\Models\Cycle;
use App\Models\CycleSignup;
use App\Models\User;
use App\Models\Week;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CycleSignupConfirmationEmailTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function cycle_signup_confirmation_email_is_being_sent()
    {
        Mail::fake();

        $mailer = new UserMailer;
        $cycle = factory(Cycle::class)->create()->addWeeks(4);
        $user = factory(User::class)->create();

        $cycle->signups()->attach($user->id, [
                'div_pref_first'    => 'mens',
                'div_pref_second'   => 'mens',
                'will_captain'      => false,
            ]);

        // add availability
        $cycle->weeks->each(function($week) use ($user) {
            $user->availability()->attach($week->id, [
                'attending' => true
            ]);
        });

        $signup = CycleSignup::findOrFail($cycle->signups()->find($user->id)->pivot->id);

        $mailer->sendCycleSignupConfirmation($signup);

        Mail::assertSent(CycleSignupConfirmation::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /** @test */
    function the_view_is_being_generated_with_no_errors()
    {
        $mailer = new UserMailer;
        $cycle = factory(Cycle::class)->create()->addWeeks(4);
        $user = factory(User::class)->create();

        $cycle->signups()->attach($user->id, [
                'div_pref_first'    => 'mens',
                'div_pref_second'   => 'mens',
                'will_captain'      => false,
            ]);

        // add availability
        $cycle->weeks->each(function($week, $key) use ($user) {
            $attending = true;
            if ($key == 3) {
                $attending = false;
            }

            $user->availability()->attach($week->id, [
                'attending' => $attending
            ]);
        });

        $signup = CycleSignup::findOrFail($cycle->signups()->find($user->id)->pivot->id);

        $mailer->sendCycleSignupConfirmation($signup);
        $this->assertTrue(true);
    }
}