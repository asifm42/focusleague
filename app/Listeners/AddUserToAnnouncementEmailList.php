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
            $memberAddress = $user->email;
            $memberName = ucwords($user->name);

            // check if the email is already on the mailing list
            $existResult = $mgClient->get("lists/$listAddress/members", array(
                'address' => $memberAddress,
                ));

            if (empty($existResult->http_response_body->items)) {
                // Email doesn't exist. Add it.
                $result = $mgClient->post("lists/$listAddress/members", array(
                    'address'     => $memberAddress,
                    'name'        => $memberName,
                    'subscribed'  => true
                ));
            } else {
                // Email exists. Update the info.
                $result = $mgClient->put("lists/$listAddress/members/$memberAddress", array(
                    'name'       => $memberName
                ));
            }


        }
    }
}
