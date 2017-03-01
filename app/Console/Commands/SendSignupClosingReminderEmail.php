<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cycle;
use App\Models\User;
use App\Mailers\UserMailer;
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
     * The user mailer instance
     *
     * @var UserMailer
     */
    protected $mailer;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UserMailer $userMailer)
    {
        parent::__construct();
        $this->mailer = $userMailer;
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
            $this->error('No current cycle');
            return;
        }

        // check to see if sign-up is closing within 48 hrs
        if (!$cycle->signup_closes_at->between(Carbon::now(), Carbon::now()->addHours(48))){
            $this->error('Sign-up not closing within 48 hrs. Cycle ' . $cycle->name . ' closing/closed at ' . $cycle->signup_closes_at->toDayDateTimeString());
            return;
        }

        // send an email to each user that has not signed up for the cycle. Reject the rice players.
        $cycle->usersNotSignedUp()
            ->reject(function ($user) {
                return in_array($user->id, config('groups.rice'));
            })->each(function ($user) use ($cycle) {
                $this->mailer->sendSignupClosingReminderEmail($user, $cycle);

                $this->info('Sign-up closing reminder email queued up for id:' . $user->id
                    . ' - name: ' . $user->name
                    . ' - nickname: ' . $user->getNicknameOrShortname()
                );
            });
    }
}
