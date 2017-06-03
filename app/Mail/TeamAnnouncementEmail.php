<?php

namespace App\Mail;

use App\Models\Cycle;
use App\Models\Team;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeamAnnouncementEmail extends Mailable implements ShouldQueue
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
     * The team instance.
     *
     * @var Team
     */
    public $team;

    /**
     * The cost that will be charged to the users account for the cycle.
     *
     * @var integer
     */
    public $cost;

    /**
     * Boolean to show if user is a captain or not
     *
     * @var bool
     */
    public $isCaptain;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Cycle $cycle, Team $team)
    {
        $this->user = $user;
        $this->cycle = $cycle;
        $this->team = $team;
        $this->isCaptain = (bool) $cycle->signups->where('id', $user->id)->first()->pivot->captain;

        switch ($user->availability->where('cycle_id', $cycle->id)->where('pivot.attending', 1)->count()) {
            case 2:
                $this->cost = number_format(config('focus.cost.cycle.two_weeks') / 100, 2);
                break;
            case 3:
                $this->cost  = number_format(config('focus.cost.cycle.three_weeks') / 100, 2);
                break;
            case 4:
                $this->cost  = number_format(config('focus.cost.cycle.four_weeks') / 100, 2);
                break;
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
                    ->subject('Cycle ' . $this->cycle->name . ' Teams are set!')
                    ->markdown('emails.team_announcement');
    }
}
