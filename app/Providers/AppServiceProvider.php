<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use Laravel\Passport\Passport;

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
            $data['jsonEncodedData'] = json_encode($event->job->payload());
            $data['exception'] = $event->exception;

            // Add current timestring
            $data['timeString']     = Carbon::now()->toDayDateTimeString();

            Mail::send(['text' => 'emails.alert.queueFailing'], $data, function ($msg) {
                $msg->to('asifm42@gmail.com', 'Asif Mohammed')
                    ->from('system@focusleague.com', 'FOCUS League System')
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
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }

        Passport::ignoreMigrations();
    }
}
