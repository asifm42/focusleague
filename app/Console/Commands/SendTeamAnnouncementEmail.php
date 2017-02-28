<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cycle;
use App\Mailers\UserMailer;

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
        $cycle = Cycle::currentCycle();
        $teams = $cycle->teams;
        $teams->load('players', 'players.user');
        $mailer = new UserMailer;

        if ($cycle->areTeamsPublished()) {
            foreach ($teams as $team){
                foreach ($team->players as $player){
                    $mailer->sendTeamAnnouncementEmail($player->user, $cycle, $team);
                }
            }

            $this->info('Team announcement emails queued up!');
        } else {
            $this->error('Teams are not published yet.');
        }
    }
}
