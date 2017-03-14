<?php

namespace App\Mail\Alert;

use App\Models\CycleSignup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CycleSignupAlert extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $signup;
    public $datesAttending;
    public $datesMissing;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(CycleSignup $signup)
    {
        $this->signup = $signup;
        $this->datesAttending = [];
        $this->datesMissing = [];
        $weeks = $signup->user->availability()->where('cycle_id',$signup->cycle->id)->get();

        foreach($weeks as $week){
            if ($week->pivot->attending) {
                $this->datesAttending[] = $week->starts_at->toFormattedDateString();
            } else {
                $this->datesMissing[] = $week->starts_at->toFormattedDateString();
            }
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('system@focusleague.com', 'FOCUS League System')
                    ->subject('New Cycle ' . $this->signup->cycle->name . ' Sign-up alert')
                    ->text('emails.alert.cycleSignup');
    }
}
