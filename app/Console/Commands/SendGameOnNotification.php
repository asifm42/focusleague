<?php

namespace App\Console\Commands;

use App\Models\Cycle;
use App\Models\Transaction;
use App\Models\Week;
use App\Notifications\GameOn;
use Illuminate\Console\Command;

class SendGameOnNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:sendGameOnNotification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a Game On Notification.';

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
        // get the cycle id
        $cycle_name = $this->ask('What is the name of the cycle?');

        $cycle = Cycle::findByName($cycle_name);

        $headers = ['week id', 'date', 'rainedOut'];

        $weeks = $cycle->weeks()->get(['id', 'starts_at', 'rained_out'])->toArray();

        $this->table($headers, $weeks);

        $week_id = $this->ask('What is the id of the week?');

        $week = Week::find($week_id);

        if ($week->isRainedOut()) {
            $this->error('This week (id:' . $week->id .  ') is rained out.');
            return;
        }

        foreach ($cycle->signups as $signup) {
            // if user is an admin, move on.
            if ($signup->isAdmin()) {
                continue;
            }

            // if signup is not on a team, move on to the next signup
            if (is_null($signup->pivot->team_id)) {
                continue;
            }

            // if signup is not attending that week, move on
            if (! $signup->isAvailable($week->id)){
                continue;
            }

            $signup->notify(new GameOn($week));

            // output success message
            $this->info('Game On Notification sent to for id:'. $signup->id . ' name: ' . $signup->getNicknameOrShortname());
        }
    }
}
