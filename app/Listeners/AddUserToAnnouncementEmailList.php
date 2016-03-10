<?php

namespace App\Listeners;

use App\Events\UserVerified;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mailgun\Mailgun;

class AddUserToAnnouncementEmailList
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
     * @param  UserVerified  $event
     * @return void
     */
    public function handle(UserVerified $event)
    {
        if ( app()->environment('local','production') ) {
            $user = $event->user;

            // Instantiate the client.
            $mgClient = new Mailgun(env('MAILGUN_SECRET'));
            $listAddress = 'announce@mg.focusleague.com';

            // Issue the call to the client.
            $result = $mgClient->post("lists/$listAddress/members", array(
                'address'     => $user->email,
                'name'        => $user->name,
                'subscribed'  => true
            ));
        }
    }
}
