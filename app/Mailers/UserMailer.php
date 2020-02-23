<?php
namespace App\Mailers;

use App\Mail as Mailable;
use App\Models\Cycle;
use App\Models\CycleSignup;
use App\Models\Sub;
use App\Models\Team;
use App\Models\User;
use App\Models\Week;
use Illuminate\Support\Facades\Mail;

class UserMailer extends Mailer
{
    /**
     * Sends the welcome email.
     *
     * @return void
     */
    public function sendWelcomeEmail(User $user)
    {
        Mail::to($user->email, $user->name)
            ->queue(new Mailable\WelcomeEmail($user));
    }

    /**
     * Sends an email to the user confirming their sign-up for a cycle.
     *
     * @return void
     */
    public function sendCycleSignupConfirmation(CycleSignup $signup)
    {
        Mail::to($signup->user->email, $signup->user->name)
            ->queue(new Mailable\CycleSignupConfirmation($signup));
    }

    /**
     * Sends an email to the user confirming their sign-up as a sub.
     *
     * @return void
     */
    public function sendSubSignupConfirmationEmail(Sub $sub)
    {
        Mail::to($sub->user->email, $sub->user->name)
            ->queue(new Mailable\SubSignupConfirmation($sub));
    }

    /**
     * Sends an email to the user announcing sign up closure.
     *
     * @return void
     */
    public function sendSignUpClosedEmail(User $user, Cycle $cycle)
    {
        Mail::to($user->email, $user->name)
            ->queue(new Mailable\SignupClosedEmail($user, $cycle));
    }

    /**
     * Sends an email to the user announcing their team.
     *
     * @return void
     */
    public function sendTeamAnnouncementEmail(User $user, Cycle $cycle, Team $team)
    {
        Mail::to($user->email, $user->name)
            ->queue(new Mailable\TeamAnnouncementEmail($user, $cycle, $team));
    }

    /**
     * Sends an email to the user with their balance info and reminding them to pay.
     *
     * @return void
     */
    public function sendBalanceReminderEmail(User $user)
    {
        Mail::to($user->email, $user->name)
            ->queue(new Mailable\BalanceReminderEmail($user));
    }


    /**
     * Sends an email to the user reminding them that sign-up is closing soon.
     *
     * @return void
     */
    public function sendSignupClosingReminderEmail(User $user, Cycle $cycle)
    {
        Mail::to($user->email, $user->name)
            ->queue(new Mailable\SignupClosingReminderEmail($user, $cycle));

        return;
    }

    /**
     * Sends an email to the user reminding them that sign-up is still open.
     *
     * @return void
     */
    public function sendSignupOpenReminderEmail(User $user, Cycle $cycle)
    {
        Mail::to($user->email, $user->name)
            ->queue(new Mailable\SignupOpenReminderEmail($user, $cycle));
    }

    /**
     * Sends an email to the user announcing opening of cycle sign-up.
     *
     * @return void
     */
    public function sendSignupOpenAnnouncementEmail(User $user, Cycle $cycle)
    {
        Mail::to($user->email, $user->name)
            ->queue(new Mailable\SignupOpenAnnounceEmail($user, $cycle));

        return;
    }

    /**
     * Sends an email to all Users who have a balance
     *
     * @return void
     */
    public static function sendBalanceReminderEmails()
    {
        $mailer = new Self;
        return User::all()->filter(function ($user) {
            return $user->getBalance() > 0;
        })->each(function ($user) use ($mailer) {
            $mailer->sendBalanceReminderEmail($user);
        });
    }

    /**
     * Sends an email to the user confirming their sub spot
     *
     * @return void
     */
    public function sendSubSpotConfirmationEmail(Sub $sub)
    {
        Mail::to($sub->user->email, $sub->user->name)
            ->queue(new Mailable\SubSpotConfirmationEmail($sub));
    }

    /**
     * Sends an email to the user encouraging feeback from the last cycle and reminding about upcoming cycle sign-up closing.
     *
     * @return void
     */
    public function sendNonReturnerReminderEmail(User $user, Cycle $cycle)
    {
        $view = 'emails.non_returner_reminder';
        $subject = 'Did you have fun last cycle?';
        $data=[];
        $data['user'] = $user->toArray();
        $data['cycle'] = $cycle;
        $data['cycleArr'] = $cycle->toArray();

        // // add mailgun tag header
        // $headers = ['x-mailgun-tag' => 'status_reminder'];

        return $this->sendTo($user, $subject, $view, $data);

        // return $this->sendTo($user, $subject, $view, $data, $headers);
    }

    /**
     * Sends an email to the user asking if they are still available for tonight's game.
     *
     * @return void
     */
    public function sendAvailabilityEmail(User $user)
    {
        $view = 'emails.availability';
        $subject = 'Are you still coming tonight?';
        $data=[];
        $data['user'] = $user->toArray();

        // // add mailgun tag header
        // $headers = ['x-mailgun-tag' => 'status_reminder'];

        return $this->sendTo($user, $subject, $view, $data);

        // return $this->sendTo($user, $subject, $view, $data, $headers);
    }

    /**
     * Sends an announcement email to the user.
     *
     * @return void
     */
    public function sendAnnouncementEmail(User $user, $view_name, $subject)
    {
        Mail::to($user->email, $user->name)
            ->queue(new Mailable\AnnouncementEmail($user, $view_name, $subject));
    }
}