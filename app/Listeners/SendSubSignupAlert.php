<?php

namespace App\Listeners;

use App\Events\UserSignedUpAsASub;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendSubSignupAlert
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
     * @param  UserSignedUpAsASub  $event
     * @return void
     */
    public function handle(UserSignedUpAsASub $event)
    {
        $data=[];
        $data['user'] = $event->user->toArray();
        $data['date'] = $event->week->starts_at->toDateTimeString();

        $sub = $event->week->subs->find($event->user->id);
        $data['note'] = $sub->note;
        $data['sub_created_at'] = $sub->created_at->toDateTimeString();

        // Alert email, if you want to be notified upon new registrations
        Mail::queue(['text' => 'emails.alert.subSignup'], $data, function($message)
        {
            $message->to('asifm42@gmail.com', 'Asif Mohammed')
                    ->subject('New sub sign-up');
        });
    }
}
