<?php
namespace App\Mailers;

use App\Models\User;

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
     * Sends the trial ending in 2 days reminder email.
     *
     * @return void
     */
    public function send2DayTrialReminder(User $user)
    {
        // $view = 'emails.simple.reminders.trial.expiring';
        // $data = $user->toArray();
        // $data['user'] = $user;
        // $subject = 'Your Obsidian Black trial is ending soon';

        // // add mailgun tag header
        // $headers = ['x-mailgun-tag' => 'status_reminder'];

        // return $this->sendTo($user, $subject, $view, $data, $headers);
    }
}