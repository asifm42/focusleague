<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\UserRegistered' => [
            'App\Listeners\SendVerificationEmail',
            'App\Listeners\SendNewUserRegisteredNotification',
        ],
        'App\Events\UserVerified' => [
            'App\Listeners\SendWelcomeEmail',
            // 'App\Listeners\AddUserToAnnouncementEmailList',
            // 'App\Listeners\SignInUser',
        ],
        'App\Events\VerificationCodeReset' => [
            'App\Listeners\SendVerificationEmail',
        ],
        'App\Events\UserUpdated' => [
            'App\Listeners\UpdateUserInAnnouncementEmailList',
        ],
        'Illuminate\Auth\Events\Attempting' => [
            'App\Listeners\CheckIfUserEmailIsConfirmed',
        ],
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LogLoginDetails',
        ],
        'App\Events\UserSignedUpForCycle' => [
            'App\Listeners\SendCycleSignupConfirmation',
            'App\Listeners\SendCycleSignupAlert',
        ],
        'App\Events\UserSignedUpAsASub' => [
            'App\Listeners\SendSubSignupConfirmation',
            'App\Listeners\SendSubSignupAlert',
        ],
        'App\Events\UserUpdatedSubSignup' => [
            'App\Listeners\SendSubSignupUpdateAlert',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
