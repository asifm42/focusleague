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
////////  TO-DO UPDATE THE TESTS. CAN'T ASSERT PROPERLY WHEN MULTIPLE EMAILS ARE SENT
    use DatabaseMigrations;

    public $creator;
    public $usersSignedUp;
    public $usersNotSignedUp;
    public $cycle;

    protected function arrange()
    {
        $cycle = factory(Cycle::class)->create();

        $this->usersSignedUp = factory(User::class, 3)->create();
        $this->usersNotSignedUp = factory(User::class, 5)->create();

        // sign up the users
        $this->usersSignedUp->each(function ($user) use ($cycle) {
            $cycle->signups()->attach($user->id, [
                'div_pref_first'    => 'mens',
                'div_pref_second'   => 'mens',
                'will_captain'      => false,
            ]);
        });

        $this->assertEquals(6, $cycle->usersNotSignedUp()->count()); // includes the cycle creator
        $this->assertEquals(3, $cycle->signups->count());
        $this->assertFalse($cycle->usersNotSignedUp()->contains($this->usersSignedUp->get(2)));
        $this->assertTrue($cycle->usersNotSignedUp()->contains($this->usersNotSignedUp->get(2)));
        $this->cycle = $cycle;
    }

    /** @test */
    function a_user_not_signed_up_for_the_current_cycle_is_sent_an_open_announcement_email()
    {
        $cycle = factory(Cycle::class)->create();
        $user = $cycle->creator;

        $this->assertFalse($cycle->signups->contains($user));
        Mail::fake();

        // send announcment
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
        $cycle = factory(Cycle::class)->create();
        $user = $cycle->creator;

        $cycle->signups()->attach($user->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
        ]);

        $this->assertTrue($cycle->signups->contains($user));

        Mail::fake();

        // send announcment
        $recipients = CycleMailer::sendSignupOpenAnnouncementEmail();
        $this->assertEquals(0, $recipients->count());
        $this->assertFalse($recipients->contains($user));
        Mail::assertNotSent(SignupOpenAnnounceEmail::class);

        // // Send open reminder
        // $recipients = CycleMailer::sendSignupOpenReminderEmail();
        // $this->assertEquals(0, $recipients->count());
        // $this->assertFalse($recipients->contains($user));

        // Mail::assertNotSent(SignupOpenReminderEmail::class);

        // // Send closing reminder
        // $recipients = CycleMailer::sendSignupClosingReminderEmail();
        // $this->assertEquals(0, $recipients->count());
        // $this->assertFalse($recipients->contains($user));

        // Mail::assertNotSent(SignupClosingReminderEmail::class);

        // send closed announcement
        // $recipients = CycleMailer::();
        // $this->assertEquals(0, $recipients->count());
        // $this->assertFalse($recipients->contains($user));

        // Mail::assertNotSent(::class);
    }

    /** @test */
    function a_user_not_signed_up_for_the_current_cycle_is_sent_an_open_reminder_email()
    {
        $cycle = factory(Cycle::class)->create();
        $user = $cycle->creator;

        $cycle->signups()->attach($user->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
        ]);

        $this->assertTrue($cycle->signups->contains($user));

        Mail::fake();

        // send announcment
        $recipients = CycleMailer::sendSignupOpenAnnouncementEmail();
        $this->assertEquals(0, $recipients->count());
        $this->assertFalse($recipients->contains($user));
        Mail::assertNotSent(SignupOpenAnnounceEmail::class);

        // Send open reminder
        $recipients = CycleMailer::sendSignupOpenReminderEmail();
        $this->assertEquals(0, $recipients->count());
        $this->assertFalse($recipients->contains($user));

        Mail::assertNotSent(SignupOpenReminderEmail::class);

        // Send closing reminder
        $recipients = CycleMailer::sendSignupClosingReminderEmail();
        $this->assertEquals(0, $recipients->count());
        $this->assertFalse($recipients->contains($user));

        Mail::assertNotSent(SignupClosingReminderEmail::class);

        // send closed announcement
        // $recipients = CycleMailer::();
        // $this->assertEquals(0, $recipients->count());
        // $this->assertFalse($recipients->contains($user));

        // Mail::assertNotSent(::class);
    }

    /** @test */
    function a_user_signed_up_for_the_current_cycle_is_not_sent_an_open_reminder_email()
    {

    }

    /** @test */
    function a_user_not_signed_up_for_the_current_cycle_is_sent_a_closing_reminder_email()
    {

    }

    /** @test */
    function a_user_signed_up_for_the_current_cycle_is_not_sent_a_closing_reminder_email()
    {

    }

    /** @test */
    function a_user_signed_up_for_the_current_cycle_is_sent_a_closed_announcement_email()
    {

    }

    /** @test */
    function a_user_not_signed_up_for_the_current_cycle_is_not_sent_a_closed_announcement_email()
    {

    }

    /** @test */
    function a_user_on_a_team_is_sent_a_team_announcement()
    {

    }

    /** @test */
    function a_user_signed_up_but_not_on_a_team_is_not_sent_a_team_announcement()
    {

    }

    /** @test */
    function a_user_signed_up_for_the_current_cycle_is_not_sent_a_closing_reminder_email()
    {

    }

    /** @test */
    function users_not_signed_up_for_the_current_cycle_get_an_announcement()
    {
        $this->arrange();
        Mail::fake();

        // send announcment
        CycleMailer::sendSignupOpenAnnouncementEmail();

        // assert that the unregistered users did get the email
        $this->usersNotSignedUp->each(function ($user) {
            Mail::assertSent(SignupOpenAnnounceEmail::class, function ($mail) use ($user) {
                return !$mail->hasTo($user->email);
            });
        });

        // assert that the signed up users did not get the email
        $this->usersSignedUp->each(function ($user) {
            Mail::assertSent(SignupOpenAnnounceEmail::class, function ($mail) use ($user) {
                return !$mail->hasTo($user->email);
            });
        });
    }

    /** @test */
    function users_not_signed_up_for_the_current_cycle_get_a_signup_open_reminder()
    {
        $this->arrange();
        Mail::fake();

        // send announcment
        CycleMailer::sendSignupOpenReminderEmail();

        // assert that the unregistered users did get the email
        $this->usersNotSignedUp->each(function ($user) {
            Mail::assertSent(SignupOpenReminderEmail::class, function ($mail) use ($user) {
                return $mail->hasTo($user->email);
            });
        });

        // assert that the signed up users did not get the email
        $this->usersSignedUp->each(function ($user) {
            Mail::assertSent(SignupOpenReminderEmail::class, function ($mail) use ($user) {
                return !$mail->hasTo($user->email);
            });
        });
    }

    /** @test */
    function users_not_signed_up_for_the_current_cycle_get_a_signup_closing_reminder()
    {
        $this->arrange();
        Mail::fake();

        // send announcment
        CycleMailer::sendSignupClosingReminderEmail();

        // assert that the unregistered users did get the email
        $this->usersNotSignedUp->each(function ($user) {
            Mail::assertSent(SignupClosingReminderEmail::class, function ($mail) use ($user) {
                return $mail->hasTo($user->email);
            });
        });

        // assert that the signed up users did not get the email
        $this->usersSignedUp->each(function ($user) {
            Mail::assertSent(SignupClosingReminderEmail::class, function ($mail) use ($user) {
                return !$mail->hasTo($user->email);
            });
        });
    }

    /** @test */
    function users_signed_up_for_the_current_cycle_get_a_signup_closed_email()
    {
        $this->arrange();
        Mail::fake();

        // send announcment
        CycleMailer::sendSignupClosedEmail();

        // assert that the unregistered users did not get the email
        $this->usersNotSignedUp->each(function ($user) {
            Mail::assertSent(SignupClosedEmail::class, function ($mail) use ($user) {
                return !$mail->hasTo($user->email);
            });
        });

        // assert that the signed up users did get the email
        $this->usersSignedUp->each(function ($user) {
            Mail::assertSent(SignupClosedEmail::class, function ($mail) use ($user) {
                return $mail->hasTo($user->email);
            });
        });
    }

    /** @test */
    function users_on_a_team_receive_a_team_announcement()
    {
        $cycle = factory(Cycle::class)->create();

        $team1Users = factory(User::class, 3)->create();
        $team2Users = factory(User::class, 2)->create();
        $usersSignedUpNotOnATeam = factory(User::class, 2)->create();
        $usersNotSignedUp = factory(User::class, 5)->create();

        $teams = $cycle->teams()->saveMany(factory(Team::class,2)->make());

        // sign up the users and don't place them on a team
        $usersSignedUpNotOnATeam->each(function ($user) use ($cycle, $teams) {
            $cycle->signups()->attach($user->id, [
                'div_pref_first'    => 'mens',
                'div_pref_second'   => 'mens',
                'will_captain'      => false,
            ]);
        });

        // sign up the users and place them on team 1
        $team1Users->each(function ($user) use ($cycle, $teams) {
            $cycle->signups()->attach($user->id, [
                'div_pref_first'    => 'mens',
                'div_pref_second'   => 'mens',
                'will_captain'      => false,
                'team_id'           => $teams->get(0)->id,
            ]);
        });

        // sign up the users and place them on a team 2
        $team2Users->each(function ($user) use ($cycle, $teams) {
            $cycle->signups()->attach($user->id, [
                'div_pref_first'    => 'mens',
                'div_pref_second'   => 'mens',
                'will_captain'      => false,
                'team_id'           => $teams->get(1)->id,
            ]);
        });

        $this->assertEquals(6, $cycle->usersNotSignedUp()->count()); // includes the cycle creator
        $this->assertEquals(7, $cycle->signups->count());

        Mail::fake();

        // send announcment
        CycleMailer::sendTeamAnnouncementEmail();

        // assert that the users on team 1 did get email
        $team1Users->each(function ($user) {
            Mail::assertSent(TeamAnnouncementEmail::class, function ($mail) use ($user) {
                return $mail->hasTo($user->email);
            });
        });

        // assert that the users on team 2 did get email
        $team2Users->each(function ($user) {
            Mail::assertSent(TeamAnnouncementEmail::class, function ($mail) use ($user) {
                return $mail->hasTo($user->email);
            });
        });

        // assert that the registered users not on a team did not get email
        $usersSignedUpNotOnATeam->each(function ($user) {
            Mail::assertSent(TeamAnnouncementEmail::class, function ($mail) use ($user) {
                return ! $mail->hasTo($user->email);
            });
        });

        // assert that the unregistered users did not get the email
        $usersNotSignedUp->each(function ($user) {
            Mail::assertSent(TeamAnnouncementEmail::class, function ($mail) use ($user) {
                return ! $mail->hasTo($user->email);
            });
        });
    }
}