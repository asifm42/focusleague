<?php

namespace App\Listeners;

use App\Events\UserSignedUpForCycle;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendCycleSignupAlert
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
     * @param  UserSignedUpForCycle  $event
     * @return void
     */
    public function handle(UserSignedUpForCycle $event)
    {
        $data = [];
        $data['user'] = $event->user->toArray();
        $data['cycle'] = $event->cycle->toArray();
        $data['signup'] = $event->cycleSignup->toArray();
        $data['dates_attending'] = [];
        $weeks = $event->user->availability()->where('cycle_id',$event->cycle->id)->get();

        foreach($weeks as $week){
            if ($week->pivot->attending)
                $data['dates_attending'][] = $week->starts_at->toDateTimeString();
        }

        // Alert email, if you want to be notified upon new registrations
        Mail::queue(['text' => 'emails.alert.cycleSignup'], $data, function($message)
        {
            $message->to('asifm42@gmail.com', 'Asif Mohammed')
                    ->cc('gizmolito@gmail.com', 'Nicholas Carranza')
                    ->from('system@focusleague.com', 'FOCUS League System')
                    ->subject('New cycle sign-up alert');
        });
    }
}
