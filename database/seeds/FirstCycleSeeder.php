<?php

use Illuminate\Database\Seeder;

class FirstCycleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Cycle::class)->create();
    }
}
