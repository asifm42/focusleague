<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cycle;
use App\Mailers\UserMailer;

class SendSignupClosedEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:sendSignupClosedEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends the signup closed email to all the cycle signups';

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
        $cycle = Cycle::currentCycle();
        $mailer = new UserMailer;

        $cycle->signups()->each(function($item, $key) use ($mailer, $cycle) {
            $mailer->sendSignupClosedEmail($item, $cycle);
        });
    }
}
