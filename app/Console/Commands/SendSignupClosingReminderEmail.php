<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mailers\CycleMailer;
use App\Models\Cycle;
use Carbon;

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
        if (! Cycle::currentCycle()) {
            $this->error('No Current Cycle');
            return;
        }

        // check to see if sign-up is closing within 48 hrs
        if (!Cycle::currentCycle()->signup_closes_at->between(Carbon::now(), Carbon::now()->addHours(48))){
            $this->error('Sign-up not closing within 48 hrs. Cycle ' . Cycle::currentCycle()->name . ' closing/closed at ' . Cycle::currentCycle()->signup_closes_at->toDayDateTimeString());
            return;
        }

        $recipients = CycleMailer::sendSignupClosingReminderEmail();

        $recipients->each(function($recipient) {
            $this->info(
                    'Sign-up closing reminder email queued up for id:' . $recipient->id
                    . ' - name: ' . $recipient->name
                    . ' - nickname: ' . $recipient->getNicknameOrShortname()
                );
        });
    }
}
