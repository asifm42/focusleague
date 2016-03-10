<?php

namespace App\Events;

use App\Events\Event;
use App\Models\Cycle;
use App\Models\CycleSignup;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserSignedUpForCycle extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Cycle $cycle, CycleSignup $cycleSignup)
    {
        $this->user = $user;
        $this->cycle = $cycle;
        $this->cycleSignup = $cycleSignup;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
