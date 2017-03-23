<?php

namespace App\Mail\Alert;

use App\Models\Cycle;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DelinquentsList extends Mailable
{
    use Queueable, SerializesModels;

    public $currentCycle;
    public $delinquents;
    public $signupsNotOnATeamWithABalance;
    public $userNotSignedUpwithABalance;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->currentCycle = Cycle::currentCycle();

        $this->delinquents = User::all()->filter(function ($user) {
            return $user->getBalance() > 0;
        });
        if ($this->currentCycle) {
            $this->signupsNotOnATeamWithABalance = $this->currentCycle->signupsNotOnATeam()->filter(function ($user) {
                return $user->getBalance() > 0;
            });

            $this->userNotSignedUpwithABalance = $this->currentCycle->usersNotSignedUp()->filter(function ($user) {
                return $user->getBalance() > 0;
            });
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->text('emails.alert.delinquents_list');
    }
}
