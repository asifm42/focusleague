<?php

use Illuminate\Database\Seeder;

class FirstCycleWeeksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Week::class)->create([
            'cycle_id' => 1,
            'starts_at' => '2016-03-15 20:00:00',
            'ends_at' => '2016-03-15 22:00:00',
        ]);

        factory(App\Models\Week::class)->create([
            'cycle_id' => 1,
            'starts_at' => '2016-03-22 20:00:00',
            'ends_at' => '2016-03-22 22:00:00',
        ]);
        factory(App\Models\Week::class)->create([
            'cycle_id' => 1,
            'starts_at' => '2016-03-29 20:00:00',
            'ends_at' => '2016-03-29 22:00:00',
        ]);
        factory(App\Models\Week::class)->create([
            'cycle_id' => 1,
            'starts_at' => '2016-04-05 20:00:00',
            'ends_at' => '2016-04-05 22:00:00',
        ]);
    }
}
