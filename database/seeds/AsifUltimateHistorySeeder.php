<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cycle;
use App\Weeks\Week;

class AsifUltimateHistorySignupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\UltimateHistory::class)->create([
            'user_id'=>1,
            'club_affiliation' => 'not sure',
            'years_played' => '11-15',
            'summary' => 'I have been playing Ultimate since 2000. I have competed at nationals and club worlds twice. I have played for Black Angus, Flash Flood, Doublewide, SCU Ignite.',
            'fav_defensive_position' => 'zone wing',
            'fav_offensive_position' => 'handler / mid-cutter',
            'def_or_off' => 'offensive',
            'best_skill' => 'throwing with accuracy and touch',
            'skill_to_improve' => 'defensive coverage on a handler',
            'best_throw' => 'short - mid range flick',
            'throw_to_improve' => 'scoober',
        ]);
    }
}
