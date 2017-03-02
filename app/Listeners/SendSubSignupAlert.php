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
return;
        $data=[];
        $data['user'] = $event->user->toArray();
        $data['date'] = $event->week->starts_at->toDateTimeString();

        $sub = $event->week->subs->find($event->user->id);
        $data['note'] = $sub->pivot->note;
        $data['sub_created_at'] = $sub->pivot->created_at->toDateTimeString();

        // Alert email, if you want to be notified upon new registrations
        Mail::queue(['text' => 'emails.alert.subSignup'], $data, function($message)
        {
            $message->to('asifm42@gmail.com', 'Asif Mohammed')
                    ->cc('gizmolito@gmail.com', 'Nicholas Carranza')
                    ->from('system@focusleague.com', 'FOCUS League System')
                    ->subject('New sub sign-up alert');
        });
    }
}
