<?php
namespace App\Mailers;

use App\Mail as Mailable;
use App\Models\Cycle;
use App\Models\CycleSignup;
use App\Models\Team;
use App\Models\User;
use App\Models\Week;
use Illuminate\Support\Facades\Mail;

class UserMailer extends Mailer {

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
    public function sendCycleSignupConfirmation(User $user, Cycle $cycle, CycleSignup $signup)
    {
        $view = 'emails.cycle_signup';

        $subject = 'Cycle Signup Confirmation';
        $data = [];
        $data['user'] = $user->toArray();
        $data['cycle'] = $cycle->toArray();
        $data['signup'] = $signup->toArray();
        $data['cost'] = '$24';
        $data['dates_attending'] = [];
        $data['dates_missing'] = [];
        $weeks = $user->availability()->where('cycle_id',$cycle->id)->get();

        foreach($weeks as $week){
            if ($week->pivot->attending) {
                $data['dates_attending'][] = $week->starts_at->toFormattedDateString();
            } else {
                $data['dates_missing'][] = $week->starts_at->toFormattedDateString();;
            }
        }

        if (count($data['dates_attending']) === 3){
            $data['cost'] = '$21';
        } elseif (count($data['dates_attending']) === 2) {
            $data['cost'] = '$18';
        }

        return $this->sendTo($user, $subject, $view, $data);

        // // add mailgun tag header
        // $headers = ['x-mailgun-tag' => 'status_reminder'];

        // return $this->sendTo($user, $subject, $view, $data, $headers);
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
        $view = 'emails.signup_closed';
        $subject = 'Sign-ups closed. Teams announcing tomorrow.';
        $data=[];
        $data['user'] = $user->toArray();
        $data['cycle'] = $cycle->toArray();

        // // add mailgun tag header
        // $headers = ['x-mailgun-tag' => 'status_reminder'];

        return $this->sendTo($user, $subject, $view, $data);

        // return $this->sendTo($user, $subject, $view, $data, $headers);
    }

    /**
     * Sends an email to the user announcing their team.
     *
     * @return void
     */
    public function sendTeamAnnouncementEmail(User $user, Cycle $cycle, Team $team)
    {
        $view = 'emails.team_announcement';
        $subject = 'Teams are set!';
        $data=[];
        $data['user'] = $user->toArray();
        $data['cycle'] = $cycle->toArray();
        $data['team'] = $team->toArray();
        $data['captains'] = [];
        $data['cost'] = 0;
        $data['balance'] = $user->getBalanceString();

        foreach($team->captains as $captain) {
            if ($captain->user->nickname) {
                $name = ucwords($captain->user->name) . ' aka ' . ucwords($captain->user->nickname);
            } else {
                $name = ucwords($captain->user->name);
            }
            $data['captains'][] = ['name'=>$name, 'email'=>$captain->user->email];
        }

        $weeks_attending = count($user->availability->where('cycle_id', $cycle->id)->where('pivot.attending', 1));

        switch ($weeks_attending) {
            case 2:
                $data['cost'] = config('focus_cost.cycle.two_weeks');
                break;
            case 3:
                $data['cost'] = config('focus_cost.cycle.three_weeks');
                break;
            case 4:
                $data['cost'] = config('focus_cost.cycle.four_weeks');
                break;
        }

        // // add mailgun tag header
        // $headers = ['x-mailgun-tag' => 'status_reminder'];

        return $this->sendTo($user, $subject, $view, $data);

        // return $this->sendTo($user, $subject, $view, $data, $headers);
    }

    /**
     * Sends an email to the user with their balance info and reminding them to pay.
     *
     * @return void
     */
    public function sendBalanceReminderEmail(User $user)
    {
        $view = 'emails.balance_reminder';
        $subject = 'Please clear your balance';
        $data=[];
        $data['user'] = $user->toArray();
        $data['balance'] = $user->getBalanceString();

        // // add mailgun tag header
        // $headers = ['x-mailgun-tag' => 'status_reminder'];

        return $this->sendTo($user, $subject, $view, $data);

        // return $this->sendTo($user, $subject, $view, $data, $headers);
    }


    /**
     * Sends an email to the user reminding them that sign-up is closing soon.
     *
     * @return void
     */
    public function sendSignupClosingReminderEmail(User $user, Cycle $cycle)
    {
        $view = 'emails.signup_closing_reminder';
        $subject = 'Cycle ' . $cycle->name . ' sign-up closing soon. Don\'t be left out!';
        $data=[];
        $data['user'] = $user->toArray();
        $data['cycle'] = $cycle;
        $data['cycleArr'] = $cycle->toArray();

        // add mailgun tag header
        $headers = ['x-mailgun-tag' => 'cycle_'.$cycle->name.'_signup_reminder'];

        // return $this->sendTo($user, $subject, $view, $data);

        return $this->sendTo($user, $subject, $view, $data, $headers);
    }

    /**
     * Sends an email to the user reminding them that sign-up is still open.
     *
     * @return void
     */
    public function sendSignupOpenReminderEmail(User $user, Cycle $cycle)
    {
        $view = 'emails.signup_closing_reminder';
        $subject = 'Reminder: Cycle ' . $cycle->name . ' sign-up is open!';
        $data=[];
        $data['user'] = $user->toArray();
        $data['cycle'] = $cycle;
        $data['cycleArr'] = $cycle->toArray();

        // add mailgun tag header
        $headers = ['x-mailgun-tag' => 'cycle_'.$cycle->name.'_signup_reminder'];

        // return $this->sendTo($user, $subject, $view, $data);

        return $this->sendTo($user, $subject, $view, $data, $headers);
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