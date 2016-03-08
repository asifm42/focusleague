<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cycle;

class SubsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cycle = Cycle::find(1);

        for($i=21;$i<30;$i++){
            $user = User::find($i);

            $cycle->weeks[rand(0,3)]->subs()->save($user, [
                'note' => 'I love this game'
            ]);
        }
    }
}
