<?php
namespace App\Mailers;

use App\Mail\Alert as Alert;
use App\Models\CycleSignup;
use App\Models\Sub;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AlertMailer extends Mailer
{
    /**
     * Sends an sub signup alert email to the admin.
     *
     * @return void
     */
    public function sendSubSignUpAlert(Sub $sub)
    {
        Mail::to('asifm42@gmail.com', 'Asif Mohammed')
            ->cc('gizmolito@gmail.com', 'Nicholas Carranza')
            ->queue(new Alert\SubSignupAlert($sub));
    }

    /**
     * Sends an cycle signup alert email to the admin.
     *
     * @return void
     */
    public function sendCycleSignUpAlert(CycleSignup $signup)
    {
        Mail::to('asifm42@gmail.com', 'Asif Mohammed')
            ->cc('gizmolito@gmail.com', 'Nicholas Carranza')
            ->queue(new Alert\CycleSignupAlert($signup));
    }

    /**
     * Sends an cycle signup alert email to the admin.
     *
     * @return void
     */
    public function sendNewUserRegisteredAlert(User $user)
    {
        Mail::to('asifm42@gmail.com', 'Asif Mohammed')
            ->queue(new Alert\NewUserRegisteredAlert($user));
    }
}