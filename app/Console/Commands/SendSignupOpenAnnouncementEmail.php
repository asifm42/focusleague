<?php

namespace App\Console\Commands;

use App\Mailers\CycleMailer;
use App\Models\Cycle;
use Illuminate\Console\Command;

class SendSignupOpenAnnouncementEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:sendSignupOpenAnnouncement';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends an announcement email to all players who haven’t signed up for the cycle';

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

        $recipients = CycleMailer::sendSignupOpenAnnouncementEmail();

        $recipients->each(function($recipient) {
            $this->info(
                    'Sign-up open announcement email queued up for id:' . $recipient->id
                    . ' - name: ' . $recipient->name
                    . ' - nickname: ' . $recipient->getNicknameOrShortname()
                );
        });

    }
}
