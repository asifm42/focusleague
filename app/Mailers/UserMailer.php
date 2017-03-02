<?php
namespace App\Mailers;

use App\Mail as Mailable;
use App\Mail\TeamAnnouncementEmail;
use App\Models\Cycle;
use App\Models\CycleSignup;
use App\Models\Team;
use App\Models\User;
use App\Models\Week;
use Illuminate\Support\Facades\Mail;

class UserMailer extends Mailer
{
    /**
     * Sends the verification email.
     *
     * @return void
     */
    public function verification(User $user)
    {
        $view = 'emails.verification';
        $data = $user->toArray();
        $subject = 'FOCUS League - Verify your email';

        return $this->sendTo($user, $subject, $view, $data);
    }

    /**
     * Sends the welcome email.
     *
     * @return void
     */
    public function welcome(User $user)
    {
        $view = 'emails.welcome';
        $data = $user->toArray();
        $subject = 'Welcome to FOCUS League';

        return $this->sendTo($user, $subject, $view, $data);
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
     * Sends an email to the user confirming their sign-up as an sub.
     *
     * @return void
     */
    public function sendSubSignupEmail(User $user, Week $week, Cycle $cycle)
    {
        $view = 'emails.sub_signup';
        $subject = 'Sub Signup Confirmation';
        $data=[];
        $data['user'] = $user->toArray();
        $data['cycle'] = $cycle->toArray();
        $data['date'] = $week->starts_at->toFormattedDateString();

        $sub = $week->subs->find($user->id);
        $data['note'] = $sub->note;
        $data['sub_created_at'] = $sub->created_at->toFormattedDateString();
        $data['week_index'] = $week->week_index();
        // // add mailgun tag header
        // $headers = ['x-mailgun-tag' => 'status_reminder'];

        return $this->sendTo($user, $subject, $view, $data);

        // return $this->sendTo($user, $subject, $view, $data, $headers);
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
            ->queue(new TeamAnnouncementEmail($user, $cycle, $team));
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
}