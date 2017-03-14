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
     * Sends an sub signup update alert email to the admin.
     *
     * @return void
     */
    public function sendSubSignUpUpdateAlert(Sub $sub, User $updatedBy)
    {
        Mail::to('asifm42@gmail.com', 'Asif Mohammed')
            ->cc('gizmolito@gmail.com', 'Nicholas Carranza')
            ->queue(new Alert\SubSignupUpdateAlert($sub, $updatedBy));
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
     * Sends a new user registered alert email to the admin.
     *
     * @return void
     */
    public function sendNewUserRegisteredAlert(User $user)
    {
        Mail::to('asifm42@gmail.com', 'Asif Mohammed')
            ->queue(new Alert\NewUserRegisteredAlert($user));
    }

    /**
     * Sends an user verified alert email to the admin.
     *
     * @return void
     */
    public function sendUserVerifiedAlert(User $user)
    {
        Mail::to('asifm42@gmail.com', 'Asif Mohammed')
            ->queue(new Alert\UserEmailVerifiedAlert($user));
    }
}