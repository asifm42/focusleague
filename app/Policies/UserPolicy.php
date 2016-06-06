<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class UserPolicy
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
     * Determine if user listing can be viewed by the user
     *
     * @param  \App\Models\User            $user
     * @param  \App\Models\UltimateHistory     $history
     * @return bool
     */
    public function index()
    {
        return auth()->user()->admin();
    }
}
