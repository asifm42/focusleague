<?php

namespace App\Mail;

use App\Models\Sub;
use App\Models\Week;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubTeamAnnouncementEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The user instance.
     *
     * @var User
     */
    public $week;

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
    public function __construct(Week $week)
    {
        $this->week = $week;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->week->starts_at->isToday()) {
            $subject = "Sub Assignments For Today (Cycle " . $this->week->cycle->name . " - Wk" . $this->week->index() . ")";
        } else {
            $subject = "Sub Assignments For " . $this->week->starts_at->toFormattedDateString() . " (Cycle " . $this->week->cycle->name . " - Wk" . $this->week->index() . ")";
        }

        return $this->from('support@focusleague.com', 'FOCUS League')
                    ->subject($subject)
                    ->markdown('emails.sub_team_announcement');
    }
}
