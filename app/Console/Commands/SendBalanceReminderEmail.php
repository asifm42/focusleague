<?php

namespace App\Console\Commands;

use App\Mail\BalanceReminderEmail;
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

        foreach($users as $user) {
            if ($user->getBalance() > 0) {

                Mail::to($user->email, $user->name)
                    ->queue(new BalanceReminderEmail($user));

                $this->info('Balance reminder email queued for id:'. $user->id . ' - name: ' . $user->getNicknameOrShortname() . ' - balance: ' . $user->getBalance());
            }
        }
    }
}
