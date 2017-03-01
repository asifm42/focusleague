<?php

namespace App\Listeners;

use App\Events\UserSignedUpForCycle;
use App\Mail\CycleSignupConfirmation;
use App\Mailers\UserMailer as Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendCycleSignupConfirmation
{
    /**
     * The mailer instance
     *
     * @return Mailer
     */
    protected $mailer;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = mailer;
    }

    /**
     * Handle the event.
     *
     * @param  UserSignedUpForCycle  $event
     * @return void
     */
    public function handle(UserSignedUpForCycle $event)
    {
        // Mail::to($event->user->email, $event->user->name)
        //     ->queue(new CycleSignupConfirmation($event->user, $event->cycle, $event->cycleSignup));
        $this->mailer->sendCycleSignupConfirmation($event->user, $event->cycle, $event->cycleSignup);
    }
}
