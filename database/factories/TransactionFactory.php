<?php

/*
|--------------------------------------------------------------------------
| Transaction Model Factories
|--------------------------------------------------------------------------
|
|
*/

$factory->define(App\Models\Transaction::class, function (Faker\Generator $faker) {

    return [
        'type' => 'charge',
        'description' => $faker->sentence(5, true),
        'amount' => $faker->randomFloat(2, 0, 30),
        'date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'week_id' => 0,
        'created_by' => 1
    ];
});

$factory->state(App\Models\Transaction::class, 'charge', function ($faker) {
    return [
        'type' => 'charge',
    ];
});

$factory->state(App\Models\Transaction::class, 'credit', function ($faker) {
    return [
        'type' => 'credit',
    ];
});

$factory->state(App\Models\Transaction::class, 'payment', function ($faker) {
    return [
        'type' => 'payment',
        'payment_type' => $faker->randomElement(['paypal', 'venmo', 'Chase Quickpay', 'Check', 'Cash'])
    ];
});

$factory->state(App\Models\Team::class, 'withUser', function ($faker) {
    return [
        'user_id' => function () {
            return factory(App\Models\User::class)->create()->id;
        },
    ];
});

$factory->state(App\Models\Team::class, 'withCycle', function ($faker) {
    return [
        'cycle_id' => function () {
            return factory(App\Models\Cycle::class)->create()->id;
        },
    ];
});

$factory->state(App\Models\Team::class, 'withWeek', function ($faker) {
    return [
        'week_id' => function () {
            return factory(App\Models\Week::class)->create()->id;
        },
    ];
});
