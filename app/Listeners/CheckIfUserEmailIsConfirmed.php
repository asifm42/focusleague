<?php

namespace App\Listeners;

use App\Exceptions\UnverifiedAccountException;
use App\Models\User;
use Illuminate\Auth\Events\Attempting as AttemptingLogin;

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
