<?php

namespace App\Events;

use App\Events\Event;
use App\Models\Cycle;
use App\Models\User;
use App\Models\Week;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserSignedUpAsASub extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Week $week, Cycle $cycle)
    {
        $this->user = $user;
        $this->week = $week;
        $this->cycle = $cycle;
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
