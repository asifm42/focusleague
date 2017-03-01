<?php

/*
|--------------------------------------------------------------------------
| Team Model Factories
|--------------------------------------------------------------------------
|
|
*/


$factory->define(App\Models\Team::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->word(),
        'division' => 'mens'
    ];
});

$factory->state(App\Models\Team::class, 'womens', function ($faker) {
    return [
        'division' => 'womens'
    ];
});

$factory->state(App\Models\Team::class, 'mixed', function ($faker) {
    return [
        'division' => 'mixed'
    ];
});

$factory->state(App\Models\Team::class, 'withCycle', function ($faker) {
    return [
        'cycle_id' => function () {
            return factory(App\Models\Cycle::class)->create()->id;
        },
    ];
});
