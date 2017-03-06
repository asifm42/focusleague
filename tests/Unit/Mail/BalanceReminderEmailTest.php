<?php

namespace Tests\Unit\Mail;

use App\Mail\BalanceReminderEmail;
use App\Mailers\UserMailer;
use App\Models\Cycle;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Week;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class BalanceReminderEmailTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function balance_reminder_email_is_being_sent()
    {
        Mail::fake();
        $mailer = new UserMailer;
        $mailer->sendBalanceReminderEmail($user = factory(User::class)->create());

        Mail::assertSent(BalanceReminderEmail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /** @test */
    function user_with_a_balance_is_sent_an_email()
    {
        // create a user with a balance
        $user = factory(User::class)->create();
        $user->transactions()->saveMany([
            factory(Transaction::class)->make(['amount' => 30.00]),
            factory(Transaction::class)->make(['amount' => 25.00]),
        ]);

        $this->assertEquals(55, $user->getBalance());

        Mail::fake();

        $recipients = UserMailer::sendBalanceReminderEmails();

        $this->assertTrue($recipients->contains($user));

        Mail::assertSent(BalanceReminderEmail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /** @test */
    function user_with_zero_balance_is_not_sent_an_email()
    {
        // create a user with transactions but a $0 balance
        $user = factory(User::class)->create();
        $user->transactions()->saveMany([
            factory(Transaction::class)->make(['amount' => 30.00]),
            factory(Transaction::class)->make(['amount' => 25.00]),
            factory(Transaction::class)->states('payment')->make(['amount' => 55.00]),
        ]);

        $this->assertEquals(0, $user->getBalance());

        Mail::fake();

        $recipients = UserMailer::sendBalanceReminderEmails();

        $this->assertFalse($recipients->contains($user));

        Mail::assertNotSent(BalanceReminderEmail::class);
    }

    /** @test */
    function user_with_a_negative_balance_is_not_sent_an_email()
    {
        $user = factory(User::class)->create();
        $user->transactions()->save(
            factory(Transaction::class)->states('credit')->make(['amount' => 15.00])
        );

        $this->assertEquals(-15, $user->getBalance());

        Mail::fake();

        $recipients = UserMailer::sendBalanceReminderEmails();

        $this->assertFalse($recipients->contains($user));

        Mail::assertNotSent(BalanceReminderEmail::class);
    }

    /** @test */
    function user_with_no_transactions_is_not_sent_an_email()
    {
        $user = factory(User::class)->create();

        $this->assertEquals(0, $user->getBalance());

        Mail::fake();

        $recipients = UserMailer::sendBalanceReminderEmails();

        $this->assertFalse($recipients->contains($user));

        Mail::assertNotSent(BalanceReminderEmail::class);
    }

    /** @test */
    function only_users_with_a_balance_are_sent_an_email()
    {
        Mail::fake();

        // create 3 users with a balance
        $balanceUsers = factory(User::class, 3)->create()
            ->each(function ($user) {
                $user->transactions()->save(factory(Transaction::class)->make([
                    'amount' => 30.00
                ]));
            });

        // create 2 user with a credit
        $creditUsers = factory(User::class, 2)->create();
        $creditUsers->each(function ($user) {
            $user->transactions()->save(factory(Transaction::class)->states('credit')->make([
                'amount' => 5.00,
            ]));
        });

        // create 2 users with no transactions
        $noTransUsers = factory(User::class, 2)->create();

        // create 2 users with transactions but a $0 balance
        $zeroBalanceUsers = factory(User::class, 2)->create()
            ->each(function ($user) {
                $user->transactions()->save(factory(Transaction::class)->make([
                    'amount' => 30.00,
                ]));
                $user->transactions()->save(factory(Transaction::class)->make([
                    'amount' => 25.00,
                ]));
                $user->transactions()->save(factory(Transaction::class)->states('payment')->make([
                    'amount' => 55.00,
                ]));
            });

        // Invoke the static method
        $recipients = UserMailer::sendBalanceReminderEmails();

        // Test the recipients
        $balanceUsers->each(function ($user) use ($recipients) {
            $this->assertTrue($recipients->contains($user));
        });

        $creditUsers->each(function ($user) use ($recipients) {
            $this->assertFalse($recipients->contains($user));
        });

        $noTransUsers->each(function ($user) use ($recipients) {
            $this->assertFalse($recipients->contains($user));
        });

        $zeroBalanceUsers->each(function ($user) use ($recipients) {
            $this->assertFalse($recipients->contains($user));
        });
    }

    /** @test */
    function the_view_is_being_generated_with_no_errors()
    {
        $mailer = new UserMailer;
        $mailer->sendBalanceReminderEmail(factory(User::class)->create());
        $this->assertTrue(true);
    }
}