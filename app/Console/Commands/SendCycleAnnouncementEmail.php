<?php

namespace App\Console\Commands;

use App\Mailers\UserMailer;
use App\Models\User;
use App\Models\Cycle;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendCycleAnnouncementEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:sendCycleAnnouncementEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends an announcement email to every registered player on a team for the current cycle. You must pass in the view name. Make sure you created one.';

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
        $view = $this->ask('What is the name of the view?');

        $this->info($view);

        $subject = $this->ask('What is the subject of the email?');

        $this->info($subject);

// $view = 'emails.2020Announcement';
// $subject = 'Cycle 2020-01 Registration Opens This Friday!';
        $mailer = new UserMailer;

        $cycle = Cycle::current()->first();

        // $users->reject(function ($user) {
        //         return in_array($user->id, config('focus.groups.rice'));
        //     })->each(function ($user) use ($mailer, $view, $subject) {
        //         $mailer->sendAnnouncementEmail($user, $view, $subject);
        //     });

        $cycle->teams->each(function ($team) use ($cycle, $mailer, $view, $subject) {
            $team->players->each(function ($player) use ($cycle, $team, $mailer, $view, $subject) {
                if ($player->user) {
                    $mailer->sendAnnouncementEmail($player->user, $view, $subject);
                }
            });
        });

        $this->info('Announcement emails queued up!');
    }
}
