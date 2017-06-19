<?php

namespace App\Console\Commands;

use App\Mail\AvailabilitySurvey2017Email;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendAvailabilitySurvey2017Email extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:sendAvailabilitySurvey2017Email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends the 2017 availability survey email.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::all();

        foreach($users as $user) {
            Mail::to($user)->queue(new AvailabilitySurvey2017Email($user));

            // output success message
            $this->info('2017 availability survey email queued for id:'. $user->id . ' name: ' . $user->name);
        }
    }
}
