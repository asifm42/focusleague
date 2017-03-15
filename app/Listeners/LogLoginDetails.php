<?php

namespace App\Listeners;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login as LoginEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogLoginDetails
{
    /**
     * The request
     *
     */
    private $request;

    /**
     * Create the event listener.
     *
     * @param  Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  LoginEvent  $event
     * @return void
     */
    public function handle(LoginEvent $event)
    {
        if(! auth()->viaRemember()) {
            $user = $event->user;

            $user->ip_address = $this->request->ip();
            $user->last_login = date('Y-m-d H:i:s', time());

            if (! $user->save() ){
                throw new SaveModelException($user);
            }
        }
    }
}
