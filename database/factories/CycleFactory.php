<?php

/*
|--------------------------------------------------------------------------
| Cycle Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your Cycle model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/


$factory->define(App\Models\Cycle::class, function (Faker\Generator $faker) {

    $arguments = func_get_args();
    if (isset($arguments[1]) && isset($arguments[1]['signup_opens_at'])) {
        $signupOpen = $arguments[1]['signup_opens_at'];
    } else {
        if(Carbon::now()->dayOfWeek == Carbon::WEDNESDAY) {
            $signupOpen = Carbon::today();
        } else {
            $signupOpen = new Carbon('last wednesday');
        };
    }

    return [
        'created_by' => function () {
            return factory(App\Models\User::class)->create()->id;
        },
        'signup_opens_at' => $signupOpen,
        'signup_closes_at' => $signupOpen->copy()->addDays(6)->addHours(15),
        'starts_at' => $signupOpen->copy()->addDays(6)->addHours(20),
        'ends_at' => $signupOpen->copy()->addDays(6)->addWeeks(4)->addHours(22),

        // 'signup_opens_at' => '2017-03-01 00:00:00',
        // 'signup_closes_at' => '2016-03-07 15:00:00',
        // 'starts_at' => '2016-03-07 20:00:00',
        // 'ends_at' => '2016-03-28 22:00:00',

        'name' => $signupOpen->format('Y') . '-01',
        'format' => 'TBD',
    ];
});

$factory->state(App\Models\Cycle::class, 'three-weeks', function ($faker) {
    if(Carbon::now()->dayOfWeek == Carbon::WEDNESDAY) {
        $signupOpen = Carbon::today();
    } else {
        $signupOpen = new Carbon('last wednesday');
    };

    return [
        'ends_at' => $signupOpen->copy()->addDays(6)->addWeeks(3)->addHours(22),
    ];
});
