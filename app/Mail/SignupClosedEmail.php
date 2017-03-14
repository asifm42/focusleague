<?php

namespace App\Mail;

use App\Models\Cycle;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignupClosedEmail extends Mailable implements ShouldQueue
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
                    ->subject('Cycle ' . $this->cycle->name . ' sign-up is closed. Teams announcing soon.')
                    ->markdown('emails.signup_closed');
    }
}
