<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Cycle;
use App\Models\CycleSignup;
use App\Models\User;


class CycleSignupPolicy
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
     * Determine if the given cycle signup can be updated by the user.
     *
     * @param  \App\Models\User            $user
     * @param  \App\Models\CycleSignup     $cycleSignup
     * @return bool
     */
    public function update(User $user, CycleSignup $cycleSignup)
    {
        return $user->id === $cycleSignup->user_id;
    }
}
