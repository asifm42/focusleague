<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\UltimateHistory;
use App\Models\User;

class UltimateHistoryPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Intercepts all checks
     *
     * @return mixed void|bool
     */
    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine if the given history can be viewed by the user
     *
     * @param  \App\Models\User            $user
     * @param  \App\Models\UltimateHistory     $history
     * @return bool
     */
    public function view(User $user, UltimateHistory $history)
    {
        return $user->id === $history->user_id;
    }
}
