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
        $subject = 'Obsidian Black - Verify your email';

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
        $subject = 'Welcome to Obsidian Black';

        return $this->sendTo($user, $subject, $view, $data);
    }

    /**
     * Sends the paid subscription confirmation email.
     *
     * @return void
     */
    public function paidSubscriptionConfirmation(User $user)
    {
        // STUB


        // $view = 'emails.simple.welcome';
        // $data = $user->toArray();
        // $subject = 'Your Obsidian Black subscription has been changed';

        // return $this->sendTo($user, $subject, $view, $data);
    }

    /**
     * Sends the change subscription confirmation email.
     *
     * @return void
     */
    public function changeSubscriptionConfirmation(User $user)
    {
        // STUB


        // $view = 'emails.simple.welcome';
        // $data = $user->toArray();
        // $subject = 'Your Obsidian Black subscription has been changed';

        // return $this->sendTo($user, $subject, $view, $data);
    }

    /**
     * Sends the trial ending in 10 days reminder email.
     *
     * @return void
     */
    public function send10DayTrialReminder(User $user)
    {
        $view = 'emails.simple.reminders.trial.expiring';
        $data = $user->toArray();
        $data['user'] = $user;
        $subject = 'Your Obsidian Black trial is ending soon';

        // add mailgun tag header
        $headers = ['x-mailgun-tag' => 'status_reminder'];

        return $this->sendTo($user, $subject, $view, $data, $headers);
    }

    /**
     * Sends the subscription ending in 10 days reminder email.
     *
     * @return void
     */
    public function send10DaySubscriptionReminder(User $user)
    {
        $view = 'emails.simple.reminders.subscription.expiring';
        $data = $user->toArray();
        $data['user'] = $user;
        $subject = 'Your Obsidian Black subscription is ending soon';

        // add mailgun tag header
        $headers = ['x-mailgun-tag' => 'status_reminder'];

        return $this->sendTo($user, $subject, $view, $data, $headers);
    }

    /**
     * Sends the trial ending in 2 days reminder email.
     *
     * @return void
     */
    public function send2DayTrialReminder(User $user)
    {
        $view = 'emails.simple.reminders.trial.expiring';
        $data = $user->toArray();
        $data['user'] = $user;
        $subject = 'Your Obsidian Black trial is ending soon';

        // add mailgun tag header
        $headers = ['x-mailgun-tag' => 'status_reminder'];

        return $this->sendTo($user, $subject, $view, $data, $headers);
    }

    /**
     * Sends the subscription ending in 2 days reminder email.
     *
     * @return void
     */
    public function send2DaySubscriptionReminder(User $user)
    {
        $view = 'emails.simple.reminders.subscription.expiring';
        $data = $user->toArray();
        $data['user'] = $user;
        $subject = 'Your Obsidian Black subscription is ending soon';

        // add mailgun tag header
        $headers = ['x-mailgun-tag' => 'status_reminder'];

        return $this->sendTo($user, $subject, $view, $data, $headers);
    }

    /**
     * Sends the trial has ended reminder email.
     *
     * @return void
     */
    public function sendTrialEndedReminder(User $user)
    {
        $view = 'emails.simple.reminders.trial.just_expired';
        $data = $user->toArray();
        $data['user'] = $user;
        $subject = 'Your Obsidian Black trial has expired';

        // add mailgun tag header
        $headers = ['x-mailgun-tag' => 'status_reminder'];

        return $this->sendTo($user, $subject, $view, $data, $headers);
    }

    /**
     * Sends the subscription has ended reminder email.
     *
     * @return void
     */
    public function sendSubscriptionEndedReminder(User $user)
    {
        $view = 'emails.simple.reminders.subscription.just_expired';
        $data = $user->toArray();
        $data['user'] = $user;
        $subject = 'Your Obsidian Black subscription has expired';

        // add mailgun tag header
        $headers = ['x-mailgun-tag' => 'status_reminder'];

        return $this->sendTo($user, $subject, $view, $data, $headers);
    }

    /**
     * Sends the trial has ended 30 days ago reminder email.
     *
     * @return void
     */
    public function sendTrialEnded30DaysAgoReminder(User $user)
    {
        $view = 'emails.simple.reminders.trial.expired';
        $data = $user->toArray();
        $data['user'] = $user;
        $subject = 'There is still time to save your projects';

        // add mailgun tag header
        $headers = ['x-mailgun-tag' => 'status_reminder'];

        return $this->sendTo($user, $subject, $view, $data, $headers);
    }

    /**
     * Sends the subscription has ended 30 days ago reminder email.
     *
     * @return void
     */
    public function sendSubscriptionEnded30DaysAgoReminder(User $user)
    {
        $view = 'emails.simple.reminders.subscription.expired';
        $data = $user->toArray();
        $data['user'] = $user;
        $subject = 'There is still time to save your projects';

        // add mailgun tag header
        $headers = ['x-mailgun-tag' => 'status_reminder'];

        return $this->sendTo($user, $subject, $view, $data, $headers);
    }

    /**
     * Sends the trial has ended 60 days ago reminder email.
     *
     * @return void
     */
    public function sendTrialEnded60DaysAgoReminder(User $user)
    {
        $view = 'emails.simple.reminders.trial.expired';
        $data = $user->toArray();
        $data['user'] = $user;
        $subject = 'There is still time to save your projects';

        // add mailgun tag header
        $headers = ['x-mailgun-tag' => 'status_reminder'];

        return $this->sendTo($user, $subject, $view, $data, $headers);
    }

    /**
     * Sends the subscription has ended 60 days ago reminder email.
     *
     * @return void
     */
    public function sendSubscriptionEnded60DaysAgoReminder(User $user)
    {
        $view = 'emails.simple.reminders.subscription.expired';
        $data = $user->toArray();
        $data['user'] = $user;
        $subject = 'There is still time to save your projects';

        // add mailgun tag header
        $headers = ['x-mailgun-tag' => 'status_reminder'];

        return $this->sendTo($user, $subject, $view, $data, $headers);
    }

    /**
     * Sends the trial has ended 90 days ago reminder email.
     *
     * @return void
     */
    public function sendTrialEnded90DaysAgoReminder(User $user)
    {
        $view = 'emails.simple.reminders.trial.expired';
        $data = $user->toArray();
        $data['user'] = $user;
        $subject = 'There is still time to save your projects';

        // add mailgun tag header
        $headers = ['x-mailgun-tag' => 'status_reminder'];

        return $this->sendTo($user, $subject, $view, $data, $headers);
    }

    /**
     * Sends the subscription has ended 90 days ago reminder email.
     *
     * @return void
     */
    public function sendSubscriptionEnded90DaysAgoReminder(User $user)
    {
        $view = 'emails.simple.reminders.subscription.expired';
        $data = $user->toArray();
        $data['user'] = $user;
        $subject = 'There is still time to save your projects';

        // add mailgun tag header
        $headers = ['x-mailgun-tag' => 'status_reminder'];

        return $this->sendTo($user, $subject, $view, $data, $headers);
    }

    /**
     * Sends the trial data deletion confirmation email.
     *
     * @return void
     */
    public function sendTrialDataDeletionEmail(User $user)
    {
        // STUB

        // $view = 'emails.simple.welcome';
        // $data = $user->toArray();
        // $subject = 'Welcome to Obsidian Black';

        // return $this->sendTo($user, $subject, $view, $data);
    }

    /**
     * Sends the subscription data deletion confirmation email.
     *
     * @return void
     */
    public function sendSubscriptionDataDeletionEmail(User $user)
    {
        // STUB

        // $view = 'emails.simple.welcome';
        // $data = $user->toArray();
        // $subject = 'Welcome to Obsidian Black';

        // return $this->sendTo($user, $subject, $view, $data);
    }
}