<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendNewUserRegisteredNotification
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
        $data = $event->user->toArray();

        // Alert email, if you want to be notified upon new registrations
        Mail::queue(['text' => 'emails.alert.registration'], $data, function($message)
        {
            $message->to('asifm42@gmail.com', 'Asif Mohammed')
                    ->subject('New user registration');
        });
    }
}
