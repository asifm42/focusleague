<?php

namespace Tests\Feature;

use App\Mail\SignupClosedEmail;
use App\Mailers\UserMailer;
use App\Models\Cycle;
use App\Models\UltimateHistory;
use App\Models\User;
use App\Models\Week;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SignupClosedEmailTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function users_signed_up_for_the_current_cycle_get_a_reminder()
    {
        Mail::fake();

        $mailer = new UserMailer;
        $cycle = factory(Cycle::class)->create();
        $startTime = $cycle->starts_at;
        $cycle->weeks()->saveMany([
            factory(Week::class)->make([
                'cycle_id' => $cycle->id,
                'starts_at' => $startTime
            ]),
            factory(Week::class)->make([
                'cycle_id' => $cycle->id,
                'starts_at' => $startTime->addWeek(1)
            ]),
            factory(Week::class)->make([
                'cycle_id' => $cycle->id,
                'starts_at' => $startTime->addWeek(1)
            ]),
            factory(Week::class)->make([
                'cycle_id' => $cycle->id,
                'starts_at' => $startTime->addWeek(1)
            ]),
        ]);

        $user1 = User::find($cycle->created_by);
        $user2 = factory(User::class)->create();
        $user3 = factory(User::class)->create();

        $cycle->signups()->attach($user1->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
        ]);

        $cycle->weeks->each(function($week) use ($user1) {
            $user1->availability()->attach($week->id, [
                'attending' => true
            ]);
        });

        $this->assertEquals(1, $cycle->signups->count());
        $this->assertTrue($cycle->signups->contains($user1));
        $this->assertFalse($cycle->signups->contains($user2));
        $this->assertFalse($cycle->signups->contains($user3));

        $cycle->signups->each(function ($user) use ($cycle, $mailer) {
            $mailer->sendSignUpClosedEmail($user,$cycle);
        });

        Mail::assertSent(SignupClosedEmail::class, function ($mail) use ($user2) {
            return !$mail->hasTo($user2->email);
        });

        Mail::assertSent(SignupClosedEmail::class, function ($mail) use ($user3) {
            return !$mail->hasTo($user3->email);
        });

        Mail::assertSent(SignupClosedEmail::class, function ($mail) use ($user1) {
            return $mail->hasTo($user1->email);
        });
    }
}