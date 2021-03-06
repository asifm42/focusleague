<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\User'           => 'App\Policies\UserPolicy',
        'App\Models\Post'           => 'App\Policies\PostPolicy',
        'App\Models\Cycle'          => 'App\Policies\CyclePolicy',
        'App\Models\CycleSignup'    => 'App\Policies\CycleSignupPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
