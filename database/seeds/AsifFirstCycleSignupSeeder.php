<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cycle;
use App\Weeks\Week;

class AsifFirstCycleSignupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cycle = Cycle::find(1);
        $player = User::find(1);

        // Cycle Signup
        $cycle->signups()->save($player, [
            'div_pref_first' => $player->division_preference_first,
            'div_pref_second' => $player->division_preference_second,
            'note' => Null,
            'will_captain' => false,
        ]);

        foreach($cycle->weeks as $week) {
            $week->signups()->save($player,['attending' => 1]);
        }
    }
}
