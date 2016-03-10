<?php

namespace App\Providers;

use Carbon;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\ServiceProvider;
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
        Queue::failing( function(JobFailed $event) {

            $data['jobName'] = $event->job->getName();
            $data['jsonEncodedData'] = json_encode($event->data);
            // $data['connection'] = $event->connectionName;

            // Add current timestring
            $data['timeString']     = Carbon::now()->toDayDateTimeString();

            Mail::send(['text' => 'emails.alert.queueFailing'], $data, function ($msg) {
                $msg->to('asifm42@gmail.com', 'Asif Mohammed')
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
