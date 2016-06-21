<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ChangeEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'updates emails in case data is dumped from production';

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
        if (app()->environment('local')) {
            $confirm = $this->ask('Type \'YES\' in all caps without quotes to change every user\'s email.');

            if ($confirm !== 'YES') {
                return;
            }

            $users = User::all();
            $count = 0;

            foreach ($users as $user) {
                $email = $user->email;
                $user->email = 'test' . $count . '@example.org';
                $user->save();
                $count++;
                $this->info($email . ' changed to ' . $user->email);
            }
        } else {
            $this->error('you are not in a local environment');
        }
    }
}
