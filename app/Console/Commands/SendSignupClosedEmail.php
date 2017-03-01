<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cycle;
use App\Mailers\UserMailer as Mailer;

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
     * The mailer instance.
     *
     * @var Mailer
     */
    protected $mailer;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Mailer $mailer)
    {
        parent::__construct();
        $this->mailer = $mailer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $cycle = Cycle::currentCycle();

        $cycle->signups()->each(function($signup) use ($mailer, $cycle) {
            $this->mailer->sendSignupClosedEmail($signup, $cycle);
        });
    }
}
