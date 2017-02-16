<?php

namespace App\Listeners;

use Black\Exceptions\UnverifiedAccountException;
use Black\Models\User;
use Illuminate\Auth\Events\Attempting as AttemptingLogin;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckIfUserEmailIsConfirmed
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Attempting  $event
     * @return void
     */
    public function handle(AttemptingLogin $event)
    {
        $user = User::where('email', $event->credentials['email'])->first();

        if (! $user->confirmed) {
            throw new UnverifiedAccountException($user);
        }
    }
}
