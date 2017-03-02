<?php

namespace App\Mail;

use App\Models\Sub;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubSignupConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $sub;
    public $weekIndex;
    public $cycle;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Sub $sub)
    {
        $this->sub = $sub;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('support@focusleague.com', 'FOCUS League')
                    ->subject('Cycle ' . $this->sub->week->cycle->name . ' - Wk' . $this->sub->week->index() . ' Sub Signup Confirmation')
                    ->markdown('emails.sub_signup');
    }
}
