<?php

namespace App\Listeners;

use App\Events\UserUpdatedSubSignup;
use App\Mailers\AlertMailer as Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendSubSignupUpdateAlert implements ShouldQueue
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
    public function handle(UserUpdatedSubSignup $event)
    {

        $this->mailer->sendSubSignUpUpdateAlert($event->sub, $event->updatedBy);
        return;

        $data=[];
        $data['changed_by'] = $event->updatedBy->toArray();
        $data['subUser'] = $event->sub->user->toArray();
        $data['sub'] = $event->sub->toArray();
        $data['date'] = $event->week->starts_at->toDateTimeString();

        // $sub = $event->week->subs->find($event->user->id);
        $data['note'] = $event->sub->note;
        $data['sub_created_at'] = $event->sub->created_at->toDateTimeString();
        $data['sub_updated_at'] = $event->sub->updated_at->toDateTimeString();

        // Alert email, if you want to be notified upon new registrations
        Mail::queue(['text' => 'emails.alert.subUpdated'], $data, function($message)
        {
            $message->to('asifm42@gmail.com', 'Asif Mohammed')
                    ->cc('gizmolito@gmail.com', 'Nicholas Carranza')
                    ->from('system@focusleague.com', 'FOCUS League System')
                    ->subject('Updated sub sign-up alert');
        });
    }
}
