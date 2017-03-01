<?php

namespace Tests\Feature;

use App\Mail\SignupOpenAnnounceEmail;
use App\Mailers\UserMailer;
use App\Models\Cycle;
use App\Models\UltimateHistory;
use App\Models\User;
use App\Models\Week;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SignupOpenReminderEmailTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function users_not_signed_up_for_the_current_cycle_get_an_announcement()
    {
        Mail::fake();

        Queue::fake();

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

        $usersNotSignedUp = $cycle->usersNotSignedUp();

        $this->assertEquals(2, $usersNotSignedUp->count());
        $this->assertTrue($usersNotSignedUp->contains($user2));
        $this->assertTrue($usersNotSignedUp->contains($user3));

        $usersNotSignedUp->each(function ($user) use ($cycle, $mailer) {
            $mailer->sendSignupOpenAnnouncementEmail($user,$cycle);
        });

        Mail::assertSent(SignupOpenAnnounceEmail::class, function ($mail) use ($user2) {
            return $mail->hasTo($user2->email);
        });

        Mail::assertSent(SignupOpenAnnounceEmail::class, function ($mail) use ($user3) {
            return $mail->hasTo($user3->email);
        });

        Mail::assertSent(SignupOpenAnnounceEmail::class, function ($mail) use ($user1) {
            return !$mail->hasTo($user1->email);
        });
    }
}