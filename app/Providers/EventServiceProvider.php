<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
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
            'App\Listeners\AddUserToAnnouncementEmailList',
            // 'App\Listeners\SignInUser',
        ],
        'App\Events\VerificationCodeReset' => [
            'App\Listeners\SendVerificationEmail',
        ],
        'App\Events\UserUpdated' => [
            // 'App\Listeners\UpdateUserInAnnouncementEmailList',
        ],
        'App\Events\UserSignedUpForCycle' => [
            'App\Listeners\SendCycleSignupConfirmation',
            'App\Listeners\SendCycleSignupAlert',
        ],
        'App\Events\UserSignedUpAsASub' => [
            'App\Listeners\SendSubSignupConfirmation',
            'App\Listeners\SendSubSignupAlert',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
