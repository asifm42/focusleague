<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Mailers\UserMailer;

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
        $users = User::all();
        $mailer = new UserMailer;

        foreach($users as $user) {
            if ($user->getBalance() > 0) {
                $mailer->sendBalanceReminderEmail($user);

                $this->info('Balance reminder for id:'. $user->id . ' - name: ' . $user->getNicknameOrShortname() . ' - balance: ' . $user->getBalance());
            }
        }
    }
}
