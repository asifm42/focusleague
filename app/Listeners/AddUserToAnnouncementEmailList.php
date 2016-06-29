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
        $user = $event->user;

        // Instantiate the client.
        $mgClient = new Mailgun(env('MAILGUN_SECRET'));

        if (app()->environment('local','dev')) {
            $listAddress = 'announce-test@mg.focusleague.com';
        }
        if (app()->environment('production')) {
            $listAddress = 'announce@mg.focusleague.com';
        }

        $memberName = ucwords($user->name);

        $mgClient->post("lists/$listAddress/members", [
                'address'       => $user->email,
                'name'          => $memberName,
                'subscribed'    => 'yes',
                'upsert'        => 'yes'
            ]
        );
    }
}
