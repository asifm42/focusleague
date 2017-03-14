<?php

namespace Tests\Unit;

use App\Mail\SignupClosedEmail;
use App\Mail\SignupClosingReminderEmail;
use App\Mail\SignupOpenAnnounceEmail;
use App\Mail\SignupOpenReminderEmail;
use App\Mail\TeamAnnouncementEmail;
use App\Mailers\CycleMailer;
use App\Models\Cycle;
use App\Models\Team;
use App\Models\User;
use App\Models\Week;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class CycleMailerTest extends TestCase
{
    use DatabaseMigrations;

    public $cycle;

    protected function userSignedUp()
    {
        $this->cycle = factory(Cycle::class)->create();
        $user = $this->cycle->creator;

        // sign up the creator
        $this->cycle->signups()->attach($user->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
        ]);

        $this->assertEquals(0, $this->cycle->usersNotSignedUp()->count()); // includes the cycle creator
        $this->assertEquals(1, $this->cycle->signups->count());
        $this->assertFalse($this->cycle->usersNotSignedUp()->contains($user));
        $this->assertTrue($this->cycle->signups->contains($user));

        return $user;
    }

    protected function userNotSignedUp()
    {
        $this->cycle = factory(Cycle::class)->create();
        $user = $this->cycle->creator;

        $this->assertEquals(1, $this->cycle->usersNotSignedUp()->count()); // includes the cycle creator
        $this->assertEquals(0, $this->cycle->signups->count());
        $this->assertTrue($this->cycle->usersNotSignedUp()->contains($user));
        $this->assertFalse($this->cycle->signups->contains($user));

        return $user;
    }

    /** @test */
    function a_user_not_signed_up_for_the_current_cycle_is_sent_an_open_announcement_email()
    {
        $user = $this->userNotSignedUp();

        Mail::fake();

        // send open announcment
        $recipients = CycleMailer::sendSignupOpenAnnouncementEmail();
        $this->assertEquals(1, $recipients->count());
        $this->assertTrue($recipients->contains($user));

        Mail::assertSent(SignupOpenAnnounceEmail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /** @test */
    function a_user_signed_up_for_the_current_cycle_is_not_sent_an_open_announcement_email()
    {
        $user = $this->userSignedUp();

        Mail::fake();

        // send open announcment
        $recipients = CycleMailer::sendSignupOpenAnnouncementEmail();
        $this->assertEquals(0, $recipients->count());
        $this->assertFalse($recipients->contains($user));
        Mail::assertNotSent(SignupOpenAnnounceEmail::class);
    }

    /** @test */
    function a_user_not_signed_up_for_the_current_cycle_is_sent_an_open_reminder_email()
    {
        $user = $this->userNotSignedUp();

        Mail::fake();

        // Send open reminder
        $recipients = CycleMailer::sendSignupOpenReminderEmail();
        $this->assertEquals(1, $recipients->count());
        $this->assertTrue($recipients->contains($user));

        Mail::assertSent(SignupOpenReminderEmail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /** @test */
    function a_user_signed_up_for_the_current_cycle_is_not_sent_an_open_reminder_email()
    {
        $user = $this->userSignedUp();

        Mail::fake();

        // Send open reminder
        $recipients = CycleMailer::sendSignupOpenReminderEmail();
        $this->assertEquals(0, $recipients->count());
        $this->assertFalse($recipients->contains($user));
        Mail::assertNotSent(SignupOpenReminderEmail::class);
    }

    /** @test */
    function a_user_not_signed_up_for_the_current_cycle_is_sent_a_closing_reminder_email()
    {
        $user = $this->userNotSignedUp();

        Mail::fake();

        // Send closing reminder
        $recipients = CycleMailer::sendSignupClosingReminderEmail();
        $this->assertEquals(1, $recipients->count());
        $this->assertTrue($recipients->contains($user));
        Mail::assertSent(SignupClosingReminderEmail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /** @test */
    function a_user_signed_up_for_the_current_cycle_is_not_sent_a_closing_reminder_email()
    {
        $user = $this->userSignedUp();

        Mail::fake();

        // send closing reminder
        $recipients = CycleMailer::sendSignupClosingReminderEmail();
        $this->assertEquals(0, $recipients->count());
        $this->assertFalse($recipients->contains($user));
        Mail::assertNotSent(SignupClosingReminderEmail::class);
    }

    /** @test */
    function a_user_signed_up_for_the_current_cycle_is_sent_a_closed_announcement_email()
    {
        $user = $this->userSignedUp();

        Mail::fake();

        // Send closed announcement
        $recipients = CycleMailer::sendSignUpClosedEmail();
        $this->assertEquals(1, $recipients->count());
        $this->assertTrue($recipients->contains($user));
        Mail::assertSent(SignupClosedEmail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /** @test */
    function a_user_not_signed_up_for_the_current_cycle_is_not_sent_a_closed_announcement_email()
    {
        $user = $this->userNotSignedUp();

        Mail::fake();

        // send closing reminder
        $recipients = CycleMailer::sendSignUpClosedEmail();
        $this->assertEquals(0, $recipients->count());
        $this->assertFalse($recipients->contains($user));
        Mail::assertNotSent(SignupClosedEmail::class);
    }

    /** @test */
    function a_user_on_a_team_is_sent_a_team_announcement()
    {
        $user = $this->userSignedUp();
        $team = $this->cycle->teams()->save(factory(Team::class)->make());

        $this->cycle->signups()->updateExistingPivot($user->id, [
            'team_id'      => $team->id,
        ]);

        $this->assertEquals($team->id, $this->cycle->signups('user_id', $user->id)->first()->pivot->team_id);

        Mail::fake();

        // send team announcement
        $recipients = CycleMailer::sendTeamAnnouncementEmail();
        $this->assertEquals(1, $recipients->count());
        $this->assertTrue($recipients->contains($user));
        Mail::assertSent(TeamAnnouncementEmail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /** @test */
    function a_user_signed_up_for_the_current_cycle_but_not_on_a_team_is_not_sent_a_team_announcement()
    {
        $user = $this->userSignedUp();

        $this->assertNull($this->cycle->signups('user_id', $user->id)->first()->pivot->team_id);

        Mail::fake();

        // send team announcement
        $recipients = CycleMailer::sendTeamAnnouncementEmail();
        $this->assertEquals(0, $recipients->count());
        $this->assertFalse($recipients->contains($user));
        Mail::assertNotSent(TeamAnnouncementEmail::class);
    }

    /** @test */
    function a_user_not_signed_up_for_the_current_cycle_is_not_sent_a_team_announcement()
    {
        $user = $this->userNotSignedUp();

        Mail::fake();

        // send team announcement
        $recipients = CycleMailer::sendTeamAnnouncementEmail();
        $this->assertEquals(0, $recipients->count());
        $this->assertFalse($recipients->contains($user));
        Mail::assertNotSent(TeamAnnouncementEmail::class);
    }
}