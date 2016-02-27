<?php

use Illuminate\Database\Seeder;

class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Game::class)->create();

        factory(App\Models\Game::class)->create([
            'week_id' => 1,
            'starts_at' => '2016-03-15 20:20:00',
            'ends_at' => '2016-03-15 22:00:00',
            'field' => 'Field A',
            'division'=> 'womens',
            'format'=> '7v7',
            'created_by' => 1,
        ]);
    }
}
