<?php
namespace App\Mailers;

use App\Models\Cycle;
use App\Models\User;
use App\Models\CycleSignup;
use App\Models\Week;

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
}