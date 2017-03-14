<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cycle;
use App\Models\Transaction;

class ChargeCyclePlayerFee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'charge:cyclePlayerFee {cycle_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a transaction for every player assigned to a team for the cycle';

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

        $cycle_id = $this->argument('cycle_id') ? $this->argument('cycle_id') : $this->ask('What is the id of the cycle?');

        $cycle = Cycle::find($cycle_id);
        $data = [
                'cycle_id' => $cycle->id,
                'type' => 'charge',
                'created_by' => 1,
                'date' => $cycle->starts_at->format('Y-m-d')
            ];

        foreach ($cycle->signups as $signup) {
            //$data['user_id'] = $signup->id;
            $count = 0;
            $weeks = $signup->availability()->where('cycle_id',$cycle->id)->get();

            if (is_null($signup->pivot->team_id)) {
                continue;
            }

            if ($signup->transactions()->where('type','charge')->where('cycle_id',$cycle->id)->count() >= 1) {
                continue;
            }

            foreach($weeks as $week){
                if ($week->pivot->attending) {
                    $count++;
                }
            }

            if ($count === 4){
                $data['description'] = 'Cycle ' . $cycle->name . ' - 4 week player fee';
                $data['amount'] = config('focus_cost.cycle.four_weeks');
            } elseif ($count === 3){
                $data['description'] = 'Cycle ' . $cycle->name . ' - 3 week player fee';
                $data['amount'] = config('focus_cost.cycle.three_weeks');
            } elseif ($count === 2) {
                $data['description'] = 'Cycle ' . $cycle->name . ' - 2 week player fee';
                $data['amount'] = config('focus_cost.cycle.two_weeks');
            }

            $transaction = new Transaction($data);
            $signup->transactions()->save($transaction);

            $this->info('$' . $data['amount'] . ' Player fee charged for id:'. $signup->id . ' name: ' . $signup->getNicknameOrShortname());

            if ($signup->transactions()->where('type','credit')->where('cycle_id',$cycle->id)->count() >= 1) {
                continue;
            }

            // Give discount for admin or captain
            if ($signup->isAdmin()) {
                $signup->transactions()->create([
                    'cycle_id' => $cycle->id,
                    'type' => 'credit',
                    'created_by' => 1,
                    'date' => $cycle->starts_at->format('Y-m-d'),
                    'description' => 'Cycle ' . $cycle->name . ' Admin Discount',
                    'amount' => $data['amount']
                ]);
                $this->info('$' . $data['amount'] . ' Admin Discount for id:'. $signup->id . ' name: ' . $signup->getNicknameOrShortname());
            } elseif ($signup->pivot->captain) {
                $signup->transactions()->create([
                    'cycle_id' => $cycle->id,
                    'type' => 'credit',
                    'created_by' => 1,
                    'date' => $cycle->starts_at->format('Y-m-d'),
                    'description' => 'Cycle ' . $cycle->name . ' Captain Discount',
                    'amount' => $data['amount'] * 0.25
                ]);
                $this->info('$' . $data['amount'] * 0.25 . ' Captain Discount for id:'. $signup->id . ' name: ' . $signup->getNicknameOrShortname());
            }
        }
    }
}
