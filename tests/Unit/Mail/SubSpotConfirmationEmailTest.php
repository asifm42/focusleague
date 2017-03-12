<?php

namespace Tests\Unit\Mail;

use App\Mail\SubSpotConfirmationEmail;
use App\Mailers\UserMailer;
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

class SubSpotConfirmationEmailTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function sub_spot_confirmation_email_is_being_sent()
    {
        Mail::fake();

        $mailer = new UserMailer;
        $cycle = factory(Cycle::class)->create()->addWeeks(4);
        $week = $cycle->weeks->get(1);
        $user = factory(User::class)->create();
        $team = $cycle->teams()->save(factory(Team::class)->make());

        $week->subs()->attach($user->id, [
            'team_id' => $team->id,
            'note' => ''
        ]);

        $sub = Sub::find($week->subs->first()->pivot->id);

        $mailer->sendSubSpotConfirmationEmail($sub);

        Mail::assertSent(SubSpotConfirmationEmail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /** @test */
    function the_view_is_being_generated_with_no_errors()
    {
        $mailer = new UserMailer;
        $cycle = factory(Cycle::class)->create()->addWeeks(4);
        $week = $cycle->weeks->get(1);
        $user = factory(User::class)->create();
        $team = $cycle->teams()->save(factory(Team::class)->make());

        $week->subs()->attach($user->id, [
            'team_id' => $team->id,
            'note' => ''
        ]);

        $sub = Sub::find($week->subs->first()->pivot->id);

        // // [TO-DO] add 2 previous transactions for the user
        // add a captain
        $captain1 = factory(User::class)->create();
        $cycle->signups()->attach($captain1->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
            'captain'      => true,
            'team_id' => $team->id,
        ]);

        $mailer->sendSubSpotConfirmationEmail($sub);

        // add another captain
        $captain2 = factory(User::class)->create();
        $cycle->signups()->attach($captain2->id, [
            'div_pref_first'    => 'mens',
            'div_pref_second'   => 'mens',
            'will_captain'      => false,
            'captain'      => true,
            'team_id' => $team->id,
        ]);

        $mailer->sendSubSpotConfirmationEmail($sub);

        // update the week's date for today to test today verbage
        $week->starts_at = Carbon::createFromTime('20');
        $week->save();

        $mailer->sendSubSpotConfirmationEmail($sub);
        $this->assertTrue(true);
    }
}