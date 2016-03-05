<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {

    $gender = rand(1,2) === 1 ? 'male' : 'female';
    $dominateHand = rand(1,2) === 1 ? 'right' : 'left';

    $divPref = rand(1,4);
    if ($gender === 'male') {
        if ($divPref === 1) {
            // might need to use 2 and 3 to determine rank
            // $divPref = '["mens" => 1, "mixed" => 0, "womens" => 0]';
            $divPref1 = 'mens';
            $divPref2 = 'mixed';
        } elseif ($divPref === 2) {
            // $divPref = '["mens" => 1, "mixed" => 2, "womens" => 0]';
            $divPref1 = 'mixed';
            $divPref2 = 'mens';
        } elseif ($divPref === 3) {
            // $divPref = '["mens" => 2, "mixed" => 1, "womens" => 0]';
            $divPref1 = 'mens';
            $divPref2 = NULL;
        } else {
            // $divPref = '["mens" => 0, "mixed" => 1, "womens" => 0]';
            $divPref1 = 'mixed';
            $divPref2 = NULL;
        }
    } else {
        if ($divPref === 1) {
            // $divPref = '["mens" => 0, "mixed" => 0, "womens" => 1]';
            $divPref1 = 'womens';
            $divPref2 = 'mixed';
        } elseif ($divPref === 2) {
            // $divPref = '["mens" => 0, "mixed" => 2, "womens" => 1]';
            $divPref1 = 'mixed';
            $divPref2 = 'womens';
        } elseif ($divPref === 3) {
            // $divPref = '["mens" => 0, "mixed" => 1, "womens" => 2]';
            $divPref1 = 'womens';
            $divPref2 = NULL;
        } else {
            // $divPref = '["mens" => 0, "mixed" => 1, "womens" => 0]';
            $divPref1 = 'mixed';
            $divPref2 = NULL;
        }
    }
    $seasonPasser = rand(1,2) === 1 ? NULL : '2016-10-15 11:59:59';

    return [
        'name' => $faker->name($gender),
        'nickname' => $faker->name($gender),
        'email' => $faker->email,
        'confirmed' => 1,
        'confirmation_code' => null,
        'gender' => $gender,
        'birthday' => $faker->date($format = 'Y-m-d', $min = '-18 years'),
        'cell_number' => $faker->phoneNumber(),
        'dominant_hand' => $dominateHand,
        'height' => $faker->numberBetween($min = 46, $max = 84),
        'division_preference_first' => $divPref1,
        'division_preference_second' => $divPref2,
        'image' => $faker->imageUrl($width = 640, $height = 480),
        'admin' => false,
        'season_pass_ends_on' => $seasonPasser,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Cycle::class, function (Faker\Generator $faker) {
    return [
        'created_by' => 1,
        'starts_at' => '2016-03-15 20:00:00',
        'ends_at' => '2016-04-05 22:00:00',
        'name' => '2016-01',
    ];
});

$factory->define(App\Models\Week::class, function (Faker\Generator $faker) {
    return [
        'cycle_id' => 1,
        'starts_at' => '2016-03-15 20:00:00',
        'ends_at' => '2016-03-15 22:00:00',
        'rained_out' => false,
    ];
});

$factory->define(App\Models\Game::class, function (Faker\Generator $faker) {
    return [
        'week_id' => 1,
        'starts_at' => '2016-03-15 20:20:00',
        'ends_at' => '2016-03-15 22:00:00',
        'field' => 'field A',
        'division'=> 'mens',
        'format'=> '7v7',
        'created_by' => 1,
    ];
});

$factory->define(App\Models\Post::class, function (Faker\Generator $faker) {
    return [
        'type' => 'news',
        'title' => $faker->realText($maxNbChars = 20, $indexSize = 2),
        'content' => $faker->realText($maxNbChars = 200, $indexSize = 2),
        'posted_by' => 1,
        'created_at' => $created = $faker->dateTimeBetween($startDate = '2016-03-05', $endDate = '1 week'),
        'updated_at'=> $created,
    ];
});