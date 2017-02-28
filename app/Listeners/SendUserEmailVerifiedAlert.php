<?php

namespace App\Listeners;

use App\Events\UserVerified;
use App\Mail\UserEmailVerifiedAlert;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendUserEmailVerifiedAlert implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserVerified $event)
    {
        Mail::to('asifm42@gmail.com', 'Asif Mohammed')
                ->queue(new UserEmailVerifiedAlert($event->user));
    }
}
