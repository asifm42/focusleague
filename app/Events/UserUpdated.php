<?php

namespace App\Events;

use App\Events\Event;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserUpdated extends Event
{
    use SerializesModels;

    public $user;

    public $changed;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, array $changed)
    {
        $this->user = $user;
        $this->changed = $changed;
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
