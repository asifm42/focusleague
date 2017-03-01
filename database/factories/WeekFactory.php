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
        'cycle_id' => function () {
            return factory(App\Models\Cycle::class)->create()->id;
        },
        'starts_at' => function (array $week) {
            return App\Models\User::find($week['cycle_id'])->starts_at;
        },
        'ends_at' => function (array $week) {
            $time = new Carbon($week['starts_at']);
            return $time->addHours(2);
        },
        'rained_out' => false
    ];
});

$factory->state(App\Models\Week::class, 'rained-out', function ($faker) {
    return [
        'rained_out' => true,
    ];
});
