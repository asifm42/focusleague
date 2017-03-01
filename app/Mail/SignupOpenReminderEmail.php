<?php

namespace App\Mail;

use App\Models\Cycle;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignupOpenReminderEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The user instance.
     *
     * @var User
     */
    public $user;

    /**
     * The cycle instance.
     *
     * @var User
     */
    public $cycle;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Cycle $cycle)
    {
        $this->user = $user;
        $this->cycle = $cycle;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // $view = 'emails.signup_closing_reminder';
        // $subject = 'Reminder: Cycle ' . $cycle->name . ' sign-up is open!';
        // $data=[];
        // $data['user'] = $user->toArray();
        // $data['cycle'] = $cycle;
        // $data['cycleArr'] = $cycle->toArray();

        // add mailgun tag header
        // $headers = ['x-mailgun-tag' => 'cycle_'.$cycle->name.'_signup_reminder'];

        // return $this->sendTo($user, $subject, $view, $data, $headers);


        // $this;

        return $this->from('support@focusleague.com', 'FOCUS League')
                    ->subject('Reminder: Cycle ' . $this->cycle->name . ' sign-up is open!')
                    ->markdown('emails.signup_open_reminder')
                    ->withSwiftMessage(function ($message) {
                        $headers = $message->getHeaders();
                        $headers->addTextHeader('x-mailgun-tag', 'cycle_'.$this->cycle->name.'_signup_reminder');
                    });
    }
}
