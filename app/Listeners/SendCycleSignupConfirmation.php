<?php

namespace App\Listeners;

use App\Events\UserSignedUpForCycle;
use App\Mailers\UserMailer as Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCycleSignupConfirmation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  UserSignedUpForCycle  $event
     * @return void
     */
    public function handle(UserSignedUpForCycle $event)
    {
        $this->mailer->sendCycleSignupConfirmation($event->user, $event->cycle, $event->cycleSignup);
    }
}
