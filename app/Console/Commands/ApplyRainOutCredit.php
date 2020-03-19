<?php

namespace App\Console\Commands;

use App\Models\Cycle;
use App\Models\Transaction;
use App\Models\Week;
use App\Notifications\Rainout;
use Illuminate\Console\Command;

class ApplyRainOutCredit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'credit:applyRainOutCredit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Applies a credit to a user who was affected by a rainout.';

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

        if (! $week->isRainedOut()) {
            $this->error('This week (id:' . $week->id .  ') is not rained out.');
            return;
        }

        $sendNotification = ($this->ask('Send notification?') == 'true') ? true : false;

        $data = [
            'cycle_id'      => $cycle->id,
            'week_id'       => $week_id,
            'type'          => 'credit',
            'created_by'    => 1,
            'date'          => $week->starts_at->format('Y-m-d'),
            'description'   => 'Rainout credit',
            'amount'        => config('focus.cost.rainout_credit')
        ];

        $totalAmountCredited = 0;

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

            // if signup has already been credited, move on
            if ($signup->transactions()->where('type','credit')->where('cycle_id', $cycle->id)->where('week_id', $week->id)->count() >= 1) {
                continue;
            }

            // create the transaction
            $transaction = new Transaction($data);

            // if user is a captain, then factor in the 25% discount they received.
            if ($signup->pivot->captain == 1) {
                $transaction->amount = round ( ($transaction->amount * 0.75), 2, PHP_ROUND_HALF_DOWN );
                //$transaction->amount = $transaction->amount * 0.75;
                $transaction->description = 'Rainout captain credit';
            }

            // save the signup's transaction
            $signup->transactions()->save($transaction);

            if ($sendNotification) $signup->notify(new Rainout($week));

            $totalAmountCredited += $transaction->amount;

            // output succes message
            $this->info('$' . $transaction->amount . ' ' . $transaction->description . ' applied for id:'. $signup->id . ' name: ' . $signup->getNicknameOrShortname());
        }

        $this->info('Total amount credited $' . $totalAmountCredited);
    }
}
