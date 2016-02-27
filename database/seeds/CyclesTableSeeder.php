<?php

use Illuminate\Database\Seeder;

class CyclesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Cycle::class)->create();

        // factory(App\Models\Cycle::class)->create([
        //     'created_by' => 1,
        //     'starts_at' => '2016-04-12 20:00:00',
        //     'ends_at' => '2016-05-03 22:00:00',
        //     'name' => '2016-02',
        // ]);

        // factory(App\Models\Cycle::class)->create([
        //     'created_by' => 1,
        //     'starts_at' => '2016-05-10 20:00:00',
        //     'ends_at' => '2016-05-31 22:00:00',
        //     'name' => '2016-03',
        // ]);
    }
}
