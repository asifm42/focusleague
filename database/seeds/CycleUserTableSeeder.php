<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cycle;

class CycleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cycle = Cycle::find(1);

        for($i=1;$i<20;$i++){
            $user = User::find($i);

            $cycle->signups()->save($user, [
                'div_pref_first' => $user->division_preference_first,
                'div_pref_second' => $user->division_preference_second,
                'note' => 'I love this game',
                'will_captain' => false,
            ]);
        }
    }
}
