<?php

/*
|--------------------------------------------------------------------------
| Ultimate History Model Factories
|--------------------------------------------------------------------------
|
|
*/


$factory->define(App\Models\UltimateHistory::class, function (Faker\Generator $faker) {

    return [
        'club_affiliation' => $faker->word(),
        'years_played' => '4-6',
        'summary' => $faker->sentence(15),
        'fav_defensive_position' => $faker->word(),
        'fav_offensive_position' => $faker->word(),
        'def_or_off' => $faker->word(),
        'best_skill' => $faker->word(),
        'skill_to_improve' => $faker->word(),
        'best_throw' => $faker->word(),
        'throw_to_improve' => $faker->word(),
    ];
});
