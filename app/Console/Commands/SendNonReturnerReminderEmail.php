<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cycle;
use App\Models\User;
use App\Mailers\UserMailer;
use Carbon;

class SendNonReturnerReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:sendNonReturnerReminderEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sends an email to to all the players who signed up for the previous cycle but not the current encouraging them to provide feedback and reminding them to sign up for the current cycle.';

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

        // hardcoding cycle 1 until time to figure out how to get previous cycle.
        $previousCycleSignups = Cycle::find(1)->signups;

        $nonReturners = $previousCycleSignups->diff($cycle->signups);

        // remove rice players
        $nonReturners = $nonReturners->filter(function ($item) {
                return !in_array($item->id, config('groups.rice'));
            });

        foreach($nonReturners as $user){
            $mailer->sendNonReturnerReminderEmail($user, $cycle);
            $this->info('Non-returner reminder email queued up for id:'. $user->id . ' - name: ' . $user->name . ' - nickname: ' . $user->getNicknameOrShortname());
        }
    }
}
