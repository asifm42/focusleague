<?php

namespace App\Console\Commands;

use App\Models\Cycle;
use App\Models\User;
use App\Mailers\UserMailer;
use Illuminate\Console\Command;

class SendSignupOpenReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:sendSignupOpenReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a reminder email to all players who haven’t signed up for the cycle';

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
        $cycle = Cycle::currentCycle();

        // check if there is a current cycle
        if (!$cycle){
            $this->error('No current cycle.');
            return;
        }

        $cycle->load('signups');

        // check to see if sign-up is open
        if (!$cycle->isSignupOpen()){
            $this->error('Sign-up is not open. Cycle ' . $cycle->name . ' signup closing/closed at ' . $cycle->signup_closes_at->toDayDateTimeString());
            return;
        }

        $users = User::all();
        $mailer = new UserMailer;

        $usersNotSignedUp = $users->diff($cycle->signups);

        // remove rice players
        $usersNotSignedUp = $usersNotSignedUp->filter(function ($item) {
                return !in_array($item->id, config('groups.rice'));
            });

        foreach($usersNotSignedUp as $user){
            $mailer->sendSignupOpenReminderEmail($user, $cycle);
            $this->info('Sign-up open reminder email queued up for id:'. $user->id . ' - name: ' . $user->name . ' - nickname: ' . $user->getNicknameOrShortname());
        }
    }
}
