<?php

namespace Tests\Unit\Mail;

use App\Mail\TeamAnnouncementEmail;
use App\Mailers\UserMailer;
use App\Models\Cycle;
use App\Models\Team;
use App\Models\UltimateHistory;
use App\Models\User;
use App\Models\Week;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TeamAnnouncementEmailTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function team_announcement_email_is_being_sent()
    {
        Mail::fake();

        $mailer = new UserMailer;
        $cycle = factory(Cycle::class)->create()->addWeeks(4);
        $user = factory(User::class)->create();
        $team = $cycle->teams()->save(factory(Team::class)->make());

        $mailer->sendTeamAnnouncementEmail($user, $cycle, $team);

        Mail::assertSent(TeamAnnouncementEmail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /** @test */
    function the_view_is_being_generated_with_no_errors()
    {
        $mailer = new UserMailer;
        $cycle = factory(Cycle::class)->create([
            'format' => '1 Mens 7v7, 1 Mixed 7v7. <br />Games to 15, 1 TO/half + floater.'
            ])->addWeeks(4);
        $user = factory(User::class)->create();
        $team = $cycle->teams()->save(factory(Team::class)->make());

        // add signup for user with team assignement
        $cycle->signups()->attach($user->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
            'team_id' => $team->id,
        ]);

        // add availability
        $cycle->weeks->each(function($week) use ($user) {
            $user->availability()->attach($week->id, [
                'attending' => true
            ]);
        });

        // [TO-DO] add 2 previous transactions for the user

        $mailer->sendTeamAnnouncementEmail($user, $cycle, $team);

        // add a captain
        $captain1 = factory(User::class)->create();
        $cycle->signups()->attach($captain1->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
            'captain'      => true,
            'team_id' => $team->id,
        ]);

        $mailer->sendTeamAnnouncementEmail($user, $cycle, $team);

        // add another captain
        $captain2 = factory(User::class)->create();
        $cycle->signups()->attach($captain2->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
            'captain'      => true,
            'team_id' => $team->id,
        ]);

        $mailer->sendTeamAnnouncementEmail($user, $cycle, $team);
        $this->assertTrue(true);
    }
}