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
     * @return Illuminate\Database\Eloquent\Collection
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
     * @return Illuminate\Database\Eloquent\Collection
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
     * @return Illuminate\Database\Eloquent\Collection
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
     * @return Illuminate\Database\Eloquent\Collection
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
     * Sends an email to the registered players placed on a team announcing their team.
     *
     * @return Illuminate\Database\Eloquent\Collection
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