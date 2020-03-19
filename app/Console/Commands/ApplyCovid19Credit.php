<?php

namespace App\Console\Commands;

use App\Models\Cycle;
use App\Models\Transaction;
use App\Models\Week;
use App\Notifications\Covid19;
use Illuminate\Console\Command;
use Carbon;

class ApplyCovid19Credit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'credit:applyCovid19Credit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Applies a credit to a user who was affected by the COVID-19 cancelation.';

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
        $nextWeek_id = $this->ask('What is the id of the following week?');

        $week = Week::find($week_id);
        $nextWeek = Week::find($nextWeek_id);

        if (! $week->isRainedOut()) {
            $this->error('This week (id:' . $week->id .  ') is not rained out.');
            return;
        }

        $sendNotification = ($this->ask('Send notification? True or False') == 'true') ? true : false;

        $weekTransactionData = [
            'cycle_id'      => $cycle->id,
            'week_id'       => $week_id,
            'type'          => 'credit',
            'created_by'    => 1,
            'date'          => $week->starts_at->format('Y-m-d'),
            'description'   => 'COVID-19 cancelation credit',
            'amount'        => config('focus.cost.rainout_credit')
        ];

        $nextWeekTransactionData = [
            'cycle_id'      => $cycle->id,
            'week_id'       => $nextWeek_id,
            'type'          => 'credit',
            'created_by'    => 1,
            'date'          => $nextWeek->starts_at->format('Y-m-d'),
            'description'   => 'COVID-19 cancelation credit',
            'amount'        => config('focus.cost.rainout_credit')
        ];

        $totalAmountCredited = 0;
        $delay = 0;

        foreach ($cycle->signups as $signup) {
            $amount = 0;

            // if user is an admin, move on.
            if ($signup->isAdmin()) {
                continue;
            }

            // if signup is not on a team, move on to the next signup
            if (is_null($signup->pivot->team_id)) {
                continue;
            }

            // if signup is not attending either week, move on
            if (! $signup->isAvailable($week->id) && ! $signup->isAvailable($nextWeek->id)){
                continue;
            }

            // if signup has already been credited, move on
            // if ($signup->transactions()->where('type','credit')->where('cycle_id', $cycle->id)->where('week_id', $week->id)->count() >= 1) {
            //     continue;
            // }

            // create the transactions
            $weekTransaction = new Transaction($weekTransactionData);
            $nextWeekTransaction = new Transaction($nextWeekTransactionData);

            // if user is a captain, then factor in the 25% discount they received.
            if ($signup->pivot->captain == 1) {
                $weekTransaction->amount = round ( ($weekTransaction->amount * 0.75), 2, PHP_ROUND_HALF_DOWN );
                //$weekTransaction->amount = $weekTransaction->amount * 0.75;
                $weekTransaction->description = 'COVID-19 cancelation captain credit';

                $nextWeekTransaction->amount = round ( ($nextWeekTransaction->amount * 0.75), 2, PHP_ROUND_HALF_DOWN );
                //$nextWeekTransaction->amount = $nextWeekTransaction->amount * 0.75;
                $nextWeekTransaction->description = 'COVID-19 cancelation captain credit';
            }

            // save the signup's transaction for each week they are attending
            if ($signup->isAvailable($week->id)) {
                $signup->transactions()->save($weekTransaction);
                $totalAmountCredited += $weekTransaction->amount;
                $amount += $weekTransaction->amount;
            }

            if ($signup->isAvailable($nextWeek->id)) {
                $signup->transactions()->save($nextWeekTransaction);
                $totalAmountCredited += $nextWeekTransaction->amount;
                $amount += $nextWeekTransaction->amount;
            }

            // $signup->transactions()->save($transaction);
if ($delay == 0 && $delay < 5) {
    $delay += 1;
} else {
    $delay =  0;
}
$when = Carbon::now()->addMinutes($delay);
            if ($sendNotification) $signup->notify((new Covid19($week, $nextWeek, $signup->getNicknameOrShortname()))->delay($when));
// $user->notify((new InvoicePaid($invoice))->delay($when));
            // $totalAmountCredited += $transaction->amount;

            // output succes message
            $this->info('$' . $amount . ' ' . $nextWeekTransaction->description . ' applied for id:'. $signup->id . ' name: ' . $signup->getNicknameOrShortname());
        }

        $this->info('Total amount credited $' . $totalAmountCredited);
    }
}
