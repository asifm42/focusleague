<?php

namespace App\Console\Commands;

use App\Models\Cycle;
use App\Models\Week;
use App\Models\User;
use App\Mailers\UserMailer;
use Illuminate\Console\Command;

class SendAvailabilityEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:sendAvailability';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends an email to all players signed up for tonight to see if they are coming';

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
        $cycle = Cycle::current_cycle();

        // check if there is a current cycle
        if (!$cycle){
            $this->error('No current cycle.');
            return;
        }

        $cycle->load('signups');

        $week_id = $this->ask('What is the id of the week?');

        $week = Week::find($week_id);

        $mailer = new UserMailer;

        foreach ($cycle->signups as $signup) {
            // if signup is not on a team, move on to the next signup
            if (is_null($signup->pivot->team_id)) {
                continue;
            }
            // if signup is not attending that week, move on
            if (! $signup->isAvailable($week->id)){
                continue;
            }

            $mailer->sendAvailabilityEmail($signup);
        }

        foreach ($week->subs as $sub) {
            $mailer->sendAvailabilityEmail($sub);
        }
    }
}
