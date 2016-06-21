<?php

return [

    /*
    |--------------------------------------------------------------------------
    | FOCUS League costs
    |--------------------------------------------------------------------------
    |
    | This file is for storing mobile carrier names and email gateways
    |
    |
    */

    'mobile_carriers' => [
        'att'       => ['pretty'=> 'AT&T',      'email_gateway' => 'txt.att.net'],
        'sprint'    => ['pretty'=> 'Sprint',    'email_gateway' => 'messaging.sprintpcs.com'],
        'tmobile'   => ['pretty'=> 'T-Mobile',  'email_gateway' => 'tmomail.net'],
        'verizon'   => ['pretty'=> 'Verizon',   'email_gateway' => 'vtext.com'],
        'other'     => ['pretty'=> 'Other',     'email_gateway' => ''],
    ],

];