<?php

namespace App\Events;

use App\Events\Event;
use App\Models\Cycle;
use App\Models\Sub;
use App\Models\User;
use App\Models\Week;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserUpdatedSubSignup extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Week $week, Sub $sub)
    {
        $this->updatedBy = $user;
        $this->week = $week;
        $this->sub = $sub;
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
