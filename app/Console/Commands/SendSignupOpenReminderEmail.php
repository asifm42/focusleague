<?php

namespace App\Console\Commands;

use App\Mailers\CycleMailer;
use App\Models\Cycle;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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
        if (! Cycle::currentCycle()) {
            $this->error('No Current Cycle');
            return;
        }

        if (! Cycle::currentCycle()->isSignupOpen()) {
            $this->error('Sign-up is not open. Cycle ' . Cycle::currentCycle()->name . ' signup closing/closed at ' . Cycle::currentCycle()->signup_closes_at->toDayDateTimeString());
            return;
        }

        $recipients = CycleMailer::sendSignupOpenReminderEmail();

        $recipients->each(function($recipient) {
            $this->info(
                    'Sign-up open reminder email queued up for id:' . $recipient->id
                    . ' - name: ' . $recipient->name
                    . ' - nickname: ' . $recipient->getNicknameOrShortname()
                );
        });
    }
}
