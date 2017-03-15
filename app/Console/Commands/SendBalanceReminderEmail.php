<?php

namespace App\Console\Commands;

use App\Mail\BalanceReminderEmail;
use App\Mailers\UserMailer as Mailer;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendBalanceReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:sendBalanceReminderEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends the balance reminder email to all users who have a positive balance';

    /**
     * The mailer instance.
     *
     * @var Mailer
     */
    protected $mailer;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Mailer $mailer)
    {
        parent::__construct();
        $this->mailer = $mailer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $recipients = UserMailer::sendBalanceReminderEmails();

        $recipients->each(function($recipient) {
            $this->info(
                    'Balance reminder email queued for id:'. $user->id
                    . ' - name: ' . $user->getNicknameOrShortname()
                    . ' - balance: ' . $user->getBalance()
                );
        });
    }
}
