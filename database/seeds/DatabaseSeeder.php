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
        $this->call(AsifAdminAccountSeeder::class);
        $this->call(FirstCycleSeeder::class);
        $this->call(FirstCycleWeeksSeeder::class);
        $this->call(AnnouncementPostSeeder::class);
        $this->call(AsifFirstCycleSignupSeeder::class);
        $this->call(AsifUltimateHistorySignupSeeder::class);

        // $this->call(UsersTableSeeder::class);
        // $this->call(PostsTableSeeder::class);
        // $this->call(CyclesTableSeeder::class);
        // $this->call(WeeksTableSeeder::class);
        // $this->call(GamesTableSeeder::class);
        // $this->call(CycleUserTableSeeder::class);
        // $this->call(AvailabilityTableSeeder::class);
        // $this->call(SubsTableSeeder::class);
    }
}
