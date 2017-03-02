<?php

namespace App\Mail;

use App\Models\CycleSignup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CycleSignupConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $cycle;
    public $signup;
    public $cost;
    public $attendingDates;
    public $missingDates;
    public $weeks;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(CycleSignup $signup)
    {
        $this->user = $signup->user;
        $this->cycle = $signup->cycle;
        $this->signup = $signup;
        $this->cost = config('focus.cost');
        $this->attendingDates = [];
        $this->missingDates = [];
        $this->weeks = $this->user->availability()->where('cycle_id',$this->cycle->id)->get();

        foreach($this->weeks as $week){
            if ($week->pivot->attending) {
                $this->attendingDates[] = $week->starts_at->toFormattedDateString();
            } else {
                $this->missingDates[] = $week->starts_at->toFormattedDateString();;
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
        return $this->from('support@focusleague.com', 'FOCUS League')
                    ->subject('Cycle ' . $this->cycle->name . ' Signup Confirmation')
                    ->markdown('emails.cycle_signup_confirmation');
    }
}
