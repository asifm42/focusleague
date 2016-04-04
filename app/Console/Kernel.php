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
                 ->weekly()->mondays()->at('10:40')
                 ->sendOutputTo(storage_path().'/balanceReminderEmailLog_' . date('Y_m_d') . '.log')
                 ->emailOutputTo('asifm42@gmail.com');

        $schedule->command('emails:sendBalanceReminderEmail')
                 ->weekly()->wednesdays()->at('10:00')
                 ->sendOutputTo(storage_path().'/balanceReminderEmailLog_' . date('Y_m_d') . '.log')
                 ->emailOutputTo('asifm42@gmail.com');
    }
}
