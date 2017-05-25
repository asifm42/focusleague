<?php

/*
|--------------------------------------------------------------------------
| Week Model Factories
|--------------------------------------------------------------------------
|
|
*/


$factory->define(App\Models\Week::class, function (Faker\Generator $faker) {

    return [
        'cycle_id' => factory(App\Models\Cycle::class),
        'starts_at' => function (array $week) {
            return App\Models\Cycle::find($week['cycle_id'])->starts_at;
        },
        'ends_at' => function (array $week) {
            $time = new Carbon($week['starts_at']);
            return $time->addHours(2);
        },
        'rained_out' => false,
        'status' => null
    ];
});

$factory->state(App\Models\Week::class, 'rained-out', function ($faker) {
    return [
        'rained_out' => true,
    ];
});
