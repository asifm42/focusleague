<?php

namespace App\Console\Commands;

use App\Mailers\CycleMailer;
use App\Models\Cycle;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTeamAnnouncementEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:sendTeamAnnouncementEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends an email to everyone who was placed on a team informing them which team they are on and who their captain is.';

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

        if (! Cycle::currentCycle()->areTeamsPublished()) {
            $this->error('Teams are not published yet.');
            return;
        }

        CycleMailer::sendTeamAnnouncementEmail();

        $this->info('Team announcement emails queued up!');
    }
}
