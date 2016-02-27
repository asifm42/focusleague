<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CyclesTableSeeder::class);
        $this->call(WeeksTableSeeder::class);
        $this->call(GamesTableSeeder::class);
    }
}
