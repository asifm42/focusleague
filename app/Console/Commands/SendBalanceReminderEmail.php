<?php

namespace App\Console\Commands;

use App\Mail\BalanceReminderEmail;
use App\Mailers\UserMailer;
use Illuminate\Console\Command;

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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
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
                    'Balance reminder email queued for id:'. $recipient->id
                    . ' - name: ' . $recipient->getNicknameOrShortname()
                    . ' - balance: ' . $recipient->getBalance()
                );
        });
    }
}
