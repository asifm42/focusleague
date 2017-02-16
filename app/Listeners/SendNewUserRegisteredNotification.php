<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Mail\UserRegisteredAlert;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendNewUserRegisteredNotification implements ShouldQueue
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
    public function handle(UserRegistered $event)
    {
        Mail::to('asifm42@gmail.com', 'Asif Mohammed')
                ->queue(new UserRegisteredAlert($event->user));
    }
}
