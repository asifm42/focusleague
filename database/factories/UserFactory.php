<?php

/*
|--------------------------------------------------------------------------
| User Model Factories
|--------------------------------------------------------------------------
|
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
        'nickname' => $faker->unique()->firstName($gender),
        'email' => $faker->safeEmail,
        'confirmed' => 1,
        'confirmation_code' => null,
        'gender' => $gender,
        'birthday' => $faker->date($format = 'Y-m-d', $min = '-18 years'),
        'cell_number' => $faker->phoneNumber(),
        'mobile_carrier' => 'tmobile',
        'dominant_hand' => $dominateHand,
        'height' => $faker->numberBetween($min = 46, $max = 84),
        'division_preference_first' => $divPref1,
        'division_preference_second' => $divPref2,
        'image' => $faker->imageUrl($width = 640, $height = 480),
        'admin' => 0,
        'season_pass_ends_on' => $seasonPasser,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->state(App\Models\User::class, 'admin', function ($faker) {
    return [
        'admin' => true
    ];
});

$factory->state(App\Models\User::class, 'male', function ($faker) {
    $divPref = rand(1,4);
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

    return [
        'gender' => 'male',
        'division_preference_first' => $divPref1,
        'division_preference_second' => $divPref2
    ];
});



$factory->state(App\Models\User::class, 'female', function ($faker) {
    $divPref = rand(1,4);
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

    return [
        'gender' => 'female',
        'division_preference_first' => $divPref1,
        'division_preference_second' => $divPref2
    ];
});
