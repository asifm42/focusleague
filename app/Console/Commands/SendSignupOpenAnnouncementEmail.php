<?php

namespace App\Console\Commands;

use App\Mailers\UserMailer;
use App\Models\Cycle;
use App\Models\User;
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

        // check if there is a current cycle
        if (!$cycle){
            $this->error('No current cycle.');
            return;
        }

        // check to see if sign-up is open
        if (!$cycle->isSignupOpen()){
            $this->error('Sign-up is not open. Cycle ' . $cycle->name . ' signup closing/closed at ' . $cycle->signup_closes_at->toDayDateTimeString());
            return;
        }

        // send an email to each user that has not signed up for the cycle. Reject the rice players.
        $cycle->usersNotSignedUp()
            ->reject(function ($user) {
                return in_array($user->id, config('groups.rice'));
            })->each(function ($user) use ($cycle) {
                $this->mailer->sendSignupOpenAnnouncementEmail($user, $cycle);

                $this->info(
                    'Sign-up open reminder email queued up for id:' . $user->id
                    . ' - name: ' . $user->name
                    . ' - nickname: ' . $user->getNicknameOrShortname()
                );
            });

    }
}
