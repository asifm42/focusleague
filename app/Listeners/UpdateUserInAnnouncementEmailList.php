<?php

namespace App\Listeners;

use App\Events\UserUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mailgun\Mailgun;

class UpdateUserInAnnouncementEmailList
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
     * @param  UserUpdated  $event
     * @return void
     */
    public function handle(UserUpdated $event)
    {
        if ( array_key_exists('name', $event->changed) ) {
            $user = $event->user;

            // Instantiate the client.
            $mgClient = new Mailgun(env('MAILGUN_SECRET'));

            if (app()->environment('local','dev')) {
                $listAddress = 'announce-test@mg.focusleague.com';
            }
            if (app()->environment('production')) {
                $listAddress = 'announce@mg.focusleague.com';
            }

            $memberEmail = $user->email;
            $memberName = ucwords($user->name);

            try {
                $mgClient->put("lists/$listAddress/members/$memberEmail", [
                        'name'          => $memberName
                    ]
                );
            } catch (\Mailgun\Connection\Exceptions\MissingEndpoint $e) {
                $mgClient->post("lists/$listAddress/members", [
                        'address'       => $memberEmail,
                        'name'          => $memberName,
                        'upsert'        => 'yes'
                    ]
                );
            }
        }
    }
}
