<?php

namespace Tests\Unit\Mail;

use App\Mail\Alert\DelinquentsList;
use App\Models\Cycle;
use App\Models\Team;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class DelinquentsListTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function delinquents_list_email_is_being_sent()
    {
        Mail::fake();

        Mail::to('asifm42@gmail.com', 'Asif Mohammed')->send(new DelinquentsList());

        Mail::assertSent(DelinquentsList::class, function ($mail) {
            return $mail->hasTo('asifm42@gmail.com');
        });
    }

    /** @test */
    function the_view_is_being_generated_with_no_errors_during_a_current_cycle()
    {
        $cycle = factory(Cycle::class)->create()->addWeeks(4);
        $userOnATeamWithNoBalance = factory(User::class)->create();
        $userOnATeamWithABalance = factory(User::class)->create();
        $user2OnATeamWithABalance = factory(User::class)->create();
        $userNotOnATeamWithNoBalance = factory(User::class)->create();
        $userNotOnATeamWithABalance = factory(User::class)->create();
        $userNotSignedUpWithNoBalance = factory(User::class)->create();
        $userNotSignedUpWithABalance = factory(User::class)->create();
        $captain1 = factory(User::class)->create();
        $captain2 = factory(User::class)->create();

        $cycle->teams()->saveMany([
            factory(Team::class)->make(),
            factory(Team::class)->make()
        ]);


        $cycle->signups()->attach($captain1->id, [
                'div_pref_first'    => 'mens',
                'div_pref_second'   => 'mens',
                'will_captain'      => true,
                'captain'      => true,
                'team_id'           => 1
            ]);

        $cycle->signups()->attach($captain2->id, [
                'div_pref_first'    => 'mens',
                'div_pref_second'   => 'mens',
                'will_captain'      => true,
                'captain'      => true,
                'team_id'           => 1
            ]);

        $cycle->signups()->attach($userOnATeamWithNoBalance->id, [
                'div_pref_first'    => 'mens',
                'div_pref_second'   => 'mens',
                'will_captain'      => false,
                'team_id'           => 1
            ]);

        $cycle->signups()->attach($userOnATeamWithABalance->id, [
                'div_pref_first'    => 'mens',
                'div_pref_second'   => 'mens',
                'will_captain'      => false,
                'team_id'           => 1
            ]);

        $cycle->signups()->attach($user2OnATeamWithABalance->id, [
                'div_pref_first'    => 'mens',
                'div_pref_second'   => 'mens',
                'will_captain'      => false,
                'team_id'           => 1
            ]);

        $cycle->signups()->attach($userNotOnATeamWithNoBalance->id, [
                'div_pref_first'    => 'mens',
                'div_pref_second'   => 'mens',
                'will_captain'      => false
            ]);

        $cycle->signups()->attach($userNotOnATeamWithABalance->id, [
                'div_pref_first'    => 'mens',
                'div_pref_second'   => 'mens',
                'will_captain'      => false
            ]);

        $userOnATeamWithABalance->transactions()->saveMany([
            factory(Transaction::class)->make(['amount' => 30.00]),
            factory(Transaction::class)->make(['amount' => 25.00]),
        ]);
        $user2OnATeamWithABalance->transactions()->saveMany([
            factory(Transaction::class)->make(['amount' => 10.00]),
            factory(Transaction::class)->make(['amount' => 25.00]),
        ]);
        $userNotOnATeamWithABalance->transactions()->saveMany([
            factory(Transaction::class)->make(['amount' => 18.00]),
            factory(Transaction::class)->make(['amount' => 25.00]),
        ]);
        $userNotSignedUpWithABalance->transactions()->saveMany([
            factory(Transaction::class)->make(['amount' => 18.00]),
            factory(Transaction::class)->make(['amount' => 25.00]),
        ]);

        Mail::to('asifm42@gmail.com', 'Asif Mohammed')->send(new DelinquentsList());

        $this->assertTrue(true);
    }

    /** @test */
    function the_view_is_being_generated_with_no_errors_when_there_is_no_cycle()
    {
        $users = factory(User::class, 5)->create();

        $users->get(0)->transactions()->saveMany([
            factory(Transaction::class)->make(['amount' => 30.00]),
            factory(Transaction::class)->make(['amount' => 25.00]),
        ]);
        $users->get(1)->transactions()->saveMany([
            factory(Transaction::class)->make(['amount' => 30.00]),
            factory(Transaction::class)->make(['amount' => 25.00]),
        ]);
        $users->get(3)->transactions()->saveMany([
            factory(Transaction::class)->make(['amount' => 30.00]),
            factory(Transaction::class)->make(['amount' => 25.00]),
        ]);

        Mail::to('asifm42@gmail.com', 'Asif Mohammed')->send(new DelinquentsList());

        $this->assertTrue(true);
    }
}