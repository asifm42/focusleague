<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class)->create([
            'id' => 1,
            'name' => 'Asif Mohammed',
            'nickname' => 'Sif',
            'email' => 'asifm42@gmail.com',
            'confirmed' => 1,
            'confirmation_code' => null,
            'gender' => 'male',
            'birthday' => '1980-02-23',
            'cell_number' => '8326406042',
            'dominant_hand' => 'right',
            'height' => 70,
            'division_preference_first' => 'mens',
            'division_preference_second' => 'mixed',
            'admin' => true,
            'season_pass_ends_on' => '2016-10-15 11:59:59',
            'password' => bcrypt('password'),
        ]);

        factory(App\Models\User::class, 30)->create();
        //->each(function($u) {
        //    $u->posts()->save(factory(App\Post::class)->make());
        //});
    }
}
