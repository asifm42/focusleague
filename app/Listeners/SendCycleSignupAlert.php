<?php

namespace App\Listeners;

use App\Events\UserSignedUpForCycle;
use App\Mailers\AlertMailer as Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCycleSignupAlert
{
    protected $mailer;

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
        $this->mailer->sendCycleSignupAlert($event->cycleSignup);
    }
}
