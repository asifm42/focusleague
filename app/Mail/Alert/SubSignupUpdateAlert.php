<?php

namespace App\Mail\Alert;

use App\Models\Sub;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubSignupUpdateAlert extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $sub;
    public $updatedBy;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Sub $sub, User $updatedBy)
    {
        $this->sub = $sub;
        $this->updatedBy = $updatedBy;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('system@focusleague.com', 'FOCUS League System')
                    ->subject('Updated: Cycle ' . $this->sub->week->cycle->name . ' Wk' . $this->sub->week->index() . ' Sub Sign-up alert')
                    ->text('emails.alert.subUpdated');
    }
}
