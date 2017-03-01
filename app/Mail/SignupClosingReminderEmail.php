<?php

namespace App\Mail;

use App\Models\Cycle;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignupClosingReminderEmail extends Mailable implements ShouldQueue
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
        return $this->from('support@focusleague.com', 'FOCUS League')
                    ->subject('Reminder: Cycle ' . $this->cycle->name . ' sign-up is open!')
                    ->markdown('emails.signup_closing_reminder')
                    ->withSwiftMessage(function ($message) {
                        $headers = $message->getHeaders();
                        $headers->addTextHeader('x-mailgun-tag', 'cycle_'.$this->cycle->name.'_signup_reminder');
                    });
    }
}
