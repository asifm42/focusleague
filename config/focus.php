<?php

return [

    /*
    |--------------------------------------------------------------------------
    | FOCUS League Costs
    |--------------------------------------------------------------------------
    |
    | This is for storing the costs that the focus player may endure.
    |
    |
    */

    'cost' => [
        'cycle' => [
            'sub' => 10,
            'two_weeks' => 18,
            'three_weeks' => 25,
            'four_weeks' => 30,
        ],

        'rainout_credit' => 5,

        'hourly_field_cost' => 95,
    ],

    /*
    |--------------------------------------------------------------------------
    | Groups
    |--------------------------------------------------------------------------
    |
    | This is for storing groups of players.
    |
    |
    */

    /*
     * Id of players on the Rice college team.
     *
     *
     */

    'groups' => [
        'rice' => [50,55,57,59,63,65,68,71,61,72,73,45,54,58,56,51,64,53,69,70,74],
    ],
];
