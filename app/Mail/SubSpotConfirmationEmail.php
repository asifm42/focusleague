<?php

namespace App\Mail;

use App\Models\Sub;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubSpotConfirmationEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The user instance.
     *
     * @var User
     */
    public $sub;

    /**
     * The cost that will be charged to the users account for the cycle.
     *
     * @var integer
     */
    public $cost;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Sub $sub)
    {
        $this->sub = $sub;
        $this->cost  = config('focus_cost.cycle.sub');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->sub->week->starts_at->isToday()) {
            $subject = "Your Sub Spot For Today (Cycle " . $this->sub->week->cycle->name . " - Wk" . $this->sub->week->index() . ")";
        } else {
            $subject = "Your Sub Spot For " . $this->sub->week->starts_at->toFormattedDateString() . " (Cycle " . $this->sub->week->cycle->name . " - Wk" . $this->sub->week->index() . ")";
        }

        return $this->from('support@focusleague.com', 'FOCUS League')
                    ->subject($subject)
                    ->markdown('emails.sub_spot_confirmation');
    }
}
