<?php

namespace App\Mail;

use App\Models\Cycle;
use App\Models\CycleSignup;
use App\Models\User;
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
    public function __construct(User $user, Cycle $cycle, CycleSignup $signup)
    {


        $this->user = $user;

        // // $data['cycle'] = $cycle->toArray();

        $this->cycle = $cycle;

        // $data['signup'] = $signup->toArray();

        $this->signup = $signup;
        $this->cost = config('focus_cost');

        // $data['cost'] = '$24';
        // $this->dates = (object) [
        //     'attending' => null,
        //     'missing'   => null
        // ];

        $this->attendingDates = [];
        $this->missingDates = [];

        // // $this->dates->attending = [];
        // // $this->dates->missing = [];
        // // $data['dates_attending'] = [];
        // // $data['dates_missing'] = [];

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
                    ->subject('Cycle Signup Confirmation')
                    ->markdown('emails.cycle_signup_confirmation');
    }
}
