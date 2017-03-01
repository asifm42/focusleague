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

class CycleMailer extends Mailer
{
    /**
     * Sends an email to unregistered users announcing opening of cycle sign-up.
     *
     * @return void
     */
    public static function sendSignupOpenAnnouncementEmail()
    {
        $cycle = Cycle::currentCycle();
        $mailer = new UserMailer;
        return $cycle->usersNotSignedUp()
                    ->reject(function ($user) {
                        return in_array($user->id, config('focus.groups.rice'));
                    })->each(function ($user) use ($cycle, $mailer) {
                        $mailer->sendSignupOpenAnnouncementEmail($user, $cycle);
                    });
    }

    /**
     * Sends an email to unregistered users reminding them that sign-up is still open.
     *
     * @return void
     */
    public static function sendSignupOpenReminderEmail()
    {
        $cycle = Cycle::currentCycle();
        $mailer = new UserMailer;
        return $cycle->usersNotSignedUp()
                    ->reject(function ($user) {
                        return in_array($user->id, config('focus.groups.rice'));
                    })->each(function ($user) use ($cycle, $mailer) {
                        $mailer->sendSignupOpenReminderEmail($user, $cycle);
                    });
    }

    /**
     * Sends an email to unregistered users reminding them that sign-up is closing soon.
     *
     * @return
     */
    public static function sendSignupClosingReminderEmail()
    {
        $cycle = Cycle::currentCycle();
        $mailer = new UserMailer;
        return $cycle->usersNotSignedUp()
                    ->reject(function ($user) {
                        return in_array($user->id, config('focus.groups.rice'));
                    })->each(function ($user) use ($cycle, $mailer) {
                        $mailer->sendSignupClosingReminderEmail($user, $cycle);
                    });
    }

    /**
     * Sends an email to users that are signed up that sign up is closed
     *
     * @return void
     */
    public static function sendSignUpClosedEmail()
    {
        $cycle = Cycle::currentCycle();
        $mailer = new UserMailer;

        return $cycle->signups()->each(function($signup) use ($mailer, $cycle) {
            $mailer->sendSignupClosedEmail($signup, $cycle);
        });
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
     * Sends an email to the registered players placed on a team announcing their team.
     *
     * @return void
     */
    public static function sendTeamAnnouncementEmail()
    {
        $cycle = Cycle::currentCycle();
        $cycle->load('teams', 'teams.players', 'teams.players.user');

        $mailer = new UserMailer;

        return $cycle->teams->each(function ($team) use ($cycle, $mailer) {
            $team->players->each(function ($player) use ($cycle, $team, $mailer) {
                if ($player->user) {
                    $mailer->sendTeamAnnouncementEmail($player->user, $cycle, $team);
                }
            });
        });
    }
}