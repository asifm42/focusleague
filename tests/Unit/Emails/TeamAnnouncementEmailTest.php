<?php

namespace Tests\Feature;

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
    function users_placed_on_a_team_for_the_cycle_will_receive_team_announcement()
    {
        Mail::fake();

        $mailer = new UserMailer;
        $cycle = factory(Cycle::class)->create();
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

        $user1 = User::find($cycle->created_by);
        $user2 = factory(User::class)->create();
        $user3 = factory(User::class)->create();
        $user4 = factory(User::class)->create();
        $user5 = factory(User::class)->create();
        $teams = $cycle->teams()->saveMany(factory(Team::class, 4)->make());


        $cycle->signups()->attach($user1->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
            'team_id' => $teams->get(0)->id,
        ]);

        $cycle->weeks->each(function($week) use ($user1) {
            $user1->availability()->attach($week->id, [
                'attending' => true
            ]);
        });

        $cycle->signups()->attach($user2->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
            'team_id' => $teams->get(1)->id,
        ]);

        $cycle->weeks->each(function($week) use ($user2) {
            $user2->availability()->attach($week->id, [
                'attending' => true
            ]);
        });

        // $teams->get(0)->addPlayer($user1);

        $this->assertEquals(4, $cycle->teams->count());
        $this->assertEquals(1, $cycle->teams->get(0)->players->count());
        $this->assertEquals(1, $cycle->teams->get(1)->players->count());
        $this->assertEquals($user1->id, $cycle->teams->get(0)->hasPlayer($user1)->user->id);
        $this->assertNull($cycle->teams->get(0)->hasPlayer($user2));
        $this->assertNull($cycle->teams->get(0)->hasPlayer($user3));
        $this->assertEquals($user2->id, $cycle->teams->get(1)->hasPlayer($user2)->user->id);
        $this->assertNull($cycle->teams->get(1)->hasPlayer($user1));
        $this->assertNull($cycle->teams->get(1)->hasPlayer($user3));
        // $this->assertTrue($cycle->teams->get(0)->hasPlayer($user1));
        // $this->assertFalse($cycle->teams->get(0)->hasPlayer($user2));
        // $this->assertFalse($cycle->teams->get(0)->hasPlayer($user3));
        // $this->assertTrue($cycle->teams->get(1)->hasPlayer($user2));
        // $this->assertFalse($cycle->teams->get(1)->hasPlayer($user1));
        // $this->assertFalse($cycle->teams->get(1)->hasPlayer($user3));

        $cycle->teams->each(function ($team) use ($cycle, $mailer) {
            $team->players->each(function ($player) use ($cycle, $team, $mailer) {
                if ($player->user) {
                    $mailer->sendTeamAnnouncementEmail($player->user, $cycle, $team);
                }
            });
        });

        Mail::assertSent(TeamAnnouncementEmail::class, function ($mail) use ($user2) {
            return !$mail->hasTo($user2->email);
        });

        Mail::assertSent(TeamAnnouncementEmail::class, function ($mail) use ($user3) {
            return !$mail->hasTo($user3->email);
        });

        Mail::assertSent(TeamAnnouncementEmail::class, function ($mail) use ($user1) {
            return $mail->hasTo($user1->email);
        });
    }
}