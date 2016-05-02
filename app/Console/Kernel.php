<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
        \App\Console\Commands\SendSignupClosedEmail::class,
        \App\Console\Commands\SendTeamAnnouncementEmail::class,
        \App\Console\Commands\ChargeCyclePlayerFee::class,
        \App\Console\Commands\SendBalanceReminderEmail::class,
        \App\Console\Commands\SendNonReturnerReminderEmail::class,
        \App\Console\Commands\SendSignupClosingReminderEmail::class,
        \App\Console\Commands\SendSignupOpenReminderEmail::class,
        \App\Console\Commands\ApplyRainOutCredit::class,
        // \App\Console\Commands\ChangeEmails::class,
        \App\Console\Commands\RevenueToDate::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('emails:sendBalanceReminderEmail')
                 ->weekly()->thursdays()->at('10:00')
                 ->sendOutputTo(storage_path().'/logs/balanceReminderEmailLog_' . date('Y_m_d') . '.log')
                 ->emailOutputTo('asifm42@gmail.com');

        $schedule->command('emails:sendSignupOpenReminder')
                 ->weekly()->fridays()->at('10:00')
                 ->sendOutputTo(storage_path().'/logs/signupOpenReminderEmailLog_' . date('Y_m_d') . '.log')
                 ->emailOutputTo('asifm42@gmail.com');

        $schedule->command('emails:sendSignupOpenReminder')
                 ->weekly()->mondays()->at('10:00')
                 ->sendOutputTo(storage_path().'/logs/signupOpenReminderEmailLog_' . date('Y_m_d') . '.log')
                 ->emailOutputTo('asifm42@gmail.com');

        $schedule->command('emails:sendSignupClosingReminderEmail')
                 ->weekly()->tuesdays()->at('10:00')
                 ->sendOutputTo(storage_path().'/logs/signupClosingReminderEmailLog_' . date('Y_m_d') . '.log')
                 ->emailOutputTo('asifm42@gmail.com');

        // $schedule->command('emails:sendNonReturnerReminderEmail')
        //          ->weekly()->tuesdays()->at('07:00')
        //          ->sendOutputTo(storage_path().'/logs/nonReturnerReminderEmailLog_' . date('Y_m_d') . '.log')
        //          ->emailOutputTo('asifm42@gmail.com');

    }
}
