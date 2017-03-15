<?php

namespace Tests\Unit\Mail;

use App\Mail\SubTeamAnnouncementEmail;
use App\Mailers\CycleMailer;
use App\Models\Cycle;
use App\Models\Sub;
use App\Models\Team;
use App\Models\User;
use App\Models\Week;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SubTeamAnnouncementEmailTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function sub_team_announcement_email_is_being_sent()
    {
        Mail::fake();

        $mailer = new CycleMailer;
        $cycle = factory(Cycle::class)->create()->addWeeks(4);
        $week = $cycle->weeks->get(1);
        $user = factory(User::class)->create();
        $team = $cycle->teams()->save(factory(Team::class)->make());

        $captain1 = factory(User::class)->create();
        $cycle->signups()->attach($captain1->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
            'captain'      => true,
            'team_id' => $team->id,
        ]);

        $mailer->sendSubTeamAnnouncementEmail($week->fresh());

        Mail::assertSent(SubTeamAnnouncementEmail::class, function ($mail) use ($captain1) {
            return $mail->hasTo($captain1->email);
        });
    }

    /** @test */
    function the_view_is_being_generated_with_no_errors()
    {
        $mailer = new CycleMailer;
        $cycle = factory(Cycle::class)->create()->addWeeks(4);
        $week = $cycle->weeks->get(1);
        $user = factory(User::class)->create();
        $mixedUser1 = factory(User::class)->states('male')->create();
        $mixedUser2 = factory(User::class)->states('male')->create();
        $mixedUser3 = factory(User::class)->states('female')->create();
        $womensUser = factory(User::class)->states('female')->create();

        $team = $cycle->teams()->save(factory(Team::class)->make());
        $mixedTeam1 = $cycle->teams()->save(factory(Team::class)->states('mixed')->make());
        $mixedTeam2 = $cycle->teams()->save(factory(Team::class)->states('mixed')->make());
        // $womensTeam1 = $cycle->teams()->save(factory(Team::class)->states('womens')->make());

        $captain1 = factory(User::class)->create();
        $cycle->signups()->attach($captain1->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => true,
            'captain'      => true,
            'team_id' => $team->id,
        ]);

        $captain2 = factory(User::class)->create();
        $cycle->signups()->attach($captain2->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => true,
            'captain'      => true,
            'team_id' => $team->id,
        ]);

        // add another captain
        $mixedCaptain = factory(User::class)->create();
        $cycle->signups()->attach($mixedCaptain->id, [
            'div_pref_first'    => 'mixed',
            'div_pref_second'   => 'mixed',
            'will_captain'      => true,
            'captain'      => true,
            'team_id' => $mixedTeam2->id,
        ]);

        // add another captain
        // $womensCaptain = factory(User::class)->create();
        // $cycle->signups()->attach($womensCaptain->id, [
        //     'div_pref_first'    => 'womens',
        //     'div_pref_second'   => 'womens',
        //     'will_captain'      => true,
        //     'captain'      => true,
        //     'team_id' => $womensTeam1->id,
        // ]);

        $week->subs()->attach($user->id, [
            'team_id' => $team->id,
            'note' => ''
        ]);

        $week->subs()->attach($mixedUser1->id, [
            'team_id' => $mixedTeam1->id,
            'note' => ''
        ]);

        $week->subs()->attach($mixedUser2->id, [
            'team_id' => $mixedTeam1->id,
            'note' => ''
        ]);

        $week->subs()->attach($mixedUser3->id, [
            'team_id' => $mixedTeam2->id,
            'note' => ''
        ]);

        // $week->subs()->attach($womensUser->id, [
        //     'team_id' => $womensTeam1->id,
        //     'note' => ''
        // ]);
        //
        $mailer->sendSubTeamAnnouncementEmail($week->fresh());

        // update the week's date for today to test today verbage
        $week->starts_at = Carbon::createFromTime('20');
        $week->save();

        $mailer->sendSubTeamAnnouncementEmail($week->fresh());
        $this->assertTrue(true);
    }
}