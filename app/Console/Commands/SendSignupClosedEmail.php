<?php

namespace App\Console\Commands;

use App\Mailers\CycleMailer;
use App\Models\Cycle;
use Illuminate\Console\Command;

class SendSignupClosedEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:sendSignupClosedEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends the signup closed email to all the cycle signups';


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

        if (Cycle::currentCycle()->isSignupOpen()) {
            $this->error('Sign-up is still open. Cycle ' . Cycle::currentCycle()->name . ' signup closing at ' . Cycle::currentCycle()->signup_closes_at->toDayDateTimeString());
            return;
        }

        $recipients = CycleMailer::sendSignUpClosedEmail();

        $recipients->each(function($recipient) {
            $this->info(
                    'Sign-up closed email queued up for id:' . $recipient->id
                    . ' - name: ' . $recipient->name
                    . ' - nickname: ' . $recipient->getNicknameOrShortname()
                );
        });
    }
}
