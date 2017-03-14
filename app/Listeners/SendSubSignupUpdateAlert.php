<?php

namespace App\Listeners;

use App\Events\UserUpdatedSubSignup;
use App\Mailers\AlertMailer as Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendSubSignupUpdateAlert implements ShouldQueue
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
     * @param  UserSignedUpAsASub  $event
     * @return void
     */
    public function handle(UserUpdatedSubSignup $event)
    {
        $this->mailer->sendSubSignUpUpdateAlert($event->sub, $event->updatedBy);
    }
}
