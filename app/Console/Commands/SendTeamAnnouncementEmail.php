<?php

namespace App\Console\Commands;

use App\Mail\TeamAnnouncementEmail;
use App\Mailers\UserMailer;
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
     * The mailer instance.
     *
     * @var UserMailer
     */
    protected $mailer;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UserMailer $mailer)
    {
        parent::__construct();
        $this->mailer = $mailer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $cycle = Cycle::currentCycle();
        $cycle->load('teams', 'teams.players', 'teams.players.user');

        if (! $cycle->areTeamsPublished()) {
            $this->error('Teams are not published yet.');
            return;
        }

        $cycle->teams->each(function ($team) use ($cycle) {
            $team->players->each(function ($player) use ($cycle, $team) {
                if ($player->user) {
                    // Mail::to($player->user->email, $player->user->name)
                    //     ->queue(new TeamAnnouncementEmail($player->user, $cycle, $team));
                    $this->mailer->sendTeamAnnouncementEmail($player->user, $cycle, $team);
                }
            });
        });

        $this->info('Team announcement emails queued up!');
    }
}
