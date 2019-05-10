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
        $outstanding = 0;

        $transactions = $transactions->filter(function ($transaction){
            return $transaction->created_at->gt(Carbon::parse('2016-12-31'));
        });

        $cost = $weeks->filter(function ($week) {
                return $week->created_at->gt(Carbon::parse('2018-12-31'))
                    && $week->starts_at->lt(Carbon::now())
                    && !$week->isRainedOut();
            })->count() * (9500*2);

        $charges = $transactions->filter(function($transaction) {
                return $transaction->type === 'charge';
            })->sum('amount');

        $credits = $transactions->filter(function($transaction) {
                return $transaction->type === 'credit';
            })->sum('amount');

        $payments = $transactions->filter(function($transaction) {
                return $transaction->type === 'payment';
            })->sum('amount');

        foreach($users as $user) {
            $balance = $user->getBalance();
            if ($balance > 0){
                $outstanding += $balance;
            }
        }

        $revenue = $charges - $credits;
        $income = $revenue - $cost;

        $data = [[
            'Charges'       => '$' . number_format($charges / 100, 2),
            'Credits'       => '$' . number_format($credits / 100, 2),
            'Payments'      => '$' . number_format($payments / 100, 2),
            'Revenue'       => '$' . number_format($revenue / 100, 2),
            'Outstanding'   => '$' . number_format($outstanding / 100, 2),
            'Cost'          => '$' . number_format($cost / 100, 2),
            'Income'        => '$' . number_format($income / 100, 2),
        ]];

        $this->table($headers, $data);
    }
}
