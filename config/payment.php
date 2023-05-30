<?php

return [
    'pk_key' => env('STRIPE_KEY'),
    'sk_key' => env('STRIPE_SECRET'),

    'capacity' => [
        false => env('STRIPE_CAPACITY_FREE'),
        true => env('STRIPE_CAPACITY_CONTRACTED'),
    ],

    'plans' => [
        'month' => env('STRIPE_PLAN_MONTH'),
        'year' => env('STRIPE_PLAN_YEAR'),
    ],
];