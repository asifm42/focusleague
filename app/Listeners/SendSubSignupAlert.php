<?php

namespace App\Listeners;

use App\Events\UserSignedUpAsASub;
use App\Mailers\AlertMailer as Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSubSignupAlert
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
    public function handle(UserSignedUpAsASub $event)
    {
        $this->mailer->sendSubSignupAlert($event->sub);
    }
}
