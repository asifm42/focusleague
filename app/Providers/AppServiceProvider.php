<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon;
use Mail;
use Queue;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Notify team of failing job...
        Queue::failing(function ($connection, $job, $data) {

            // Add current timestring
            $data['timeString']     = Carbon::now()->toDayDateTimeString();

            Mail::send(['text' => 'emails.alert.queueFailing'], $data, function ($msg) {
                $msg->to('asifm@obsidianlearning.com', 'Asif Mohammed')
                    ->cc('stevenw@obsidianlearning.com', 'Steven Westmoreland')
                    ->subject('A queued job has failed');
            });
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
