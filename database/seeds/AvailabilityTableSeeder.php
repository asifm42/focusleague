<?php

use Illuminate\Database\Seeder;
use App\Models\Cycle;

class AvailabilityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cycle = Cycle::find(1);

        foreach ($cycle->signups as $player){
            foreach($cycle->weeks as $week) {
                $week->signups()->save($player,['attending' => rand(0,1)]);
            }
        }
    }
}
