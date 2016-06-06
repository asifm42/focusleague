<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cycle;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Week;
use Carbon;

class RevenueToDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:revenue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gives the current revenue to date';

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
        $cycles = Cycle::all();
        $transactions = Transaction::all();
        $users = User::all();
        $weeks = Week::all();
        $headers = ['Charges', 'Credits', 'Payments', 'Revenue', 'Outstanding', 'Cost', 'Income'];
        $charges = 0;
        $credits = 0;
        $payments = 0;
        $outstanding = 0;
        $cost = 0;

        foreach($transactions as $transaction) {
            if ($transaction->type === 'charge') {
                $charges += $transaction->amount;
            } elseif ($transaction->type === 'credit') {
                $credits += $transaction->amount;
            } elseif ($transaction->type === 'payment') {
                $payments += $transaction->amount;
            }
        }

        foreach($users as $user) {
            $balance = $user->getBalance();
            if ($balance > 0){
                $outstanding += $balance;
            }
        }

        // foreach ($cycles as $cycle) {
        //     if($cycle->ends_at->lt(Carbon::now())) {
        //         foreach($cycle->weeks as $week) {
        //             if ($week->starts_at->lt(Carbon::now()) && !$week->isRainedOut()) {
        //                 $cost += 160;
        //             }
        //         }
        //     }
        // }

        foreach($weeks as $week) {
            if ($week->starts_at->lt(Carbon::now()) && !$week->isRainedOut()) {
                $cost += 160;
            }
        }


        $revenue = $charges - $credits;
        $income = $revenue - $cost;

        $data = [[
            'Charges'       => '$'.$charges,
            'Credits'       => '$'.$credits,
            'Payments'      => '$'.$payments,
            'Revenue'       => '$'.$revenue,
            'Outstanding'   => '$'.$outstanding,
            'Cost'          => '$'.$cost,
            'Income'        => '$'.$income,
        ]];

        $this->table($headers, $data);
    }
}
