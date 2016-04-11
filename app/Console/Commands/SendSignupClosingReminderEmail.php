<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cycle;
use App\Models\User;
use App\Mailers\UserMailer;

class SendSignupClosingReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:sendSignupClosingReminderEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends an email to all players who have not signed up for the current cycle reminding them sign up is closing soon.';

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
        $cycle = Cycle::current_cycle();

        // check if there is a current cycle
        if (!$cycle){
            return;
        }

        $cycle->load('signups');

        // check to see if sign-up is open
        if (!$cycle->signup_closes_at->between(Carbon::now(), Carbon::now()->addHours(48))){
            $this->error('Sign-up not closing within 48 hrs. Cycle ' . $cycle->name . ' closing/closed at ' . $cycle->signup_closes_at->toDayDateTimeString());
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
            $mailer->sendSignupClosingReminderEmail($user, $cycle);
            $this->info('Sign-up closing reminder email queued up for id:'. $user->id . ' - name: ' . $user->name . ' - nickname: ' . $user->getNicknameOrShortname());
        }
    }
}
