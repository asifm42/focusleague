<?php

namespace App\Listeners;

use App\Events\UserVerified;
use App\Mailers\AlertMailer as Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendUserEmailVerifiedAlert implements ShouldQueue
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
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserVerified $event)
    {
        $this->mailer->sendUserVerifiedAlert($event->user);
    }
}
