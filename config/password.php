<?php

return [
    'min' => env('PASSWORD_MIN', 8),
    'mixed_case' => env('PASSWORD_MIXED_CASE', false),
    'letters' => env('PASSWORD_LETTERS', false),
    'number' => env('PASSWORD_SYMBOLS', false),
    'uncompromised' => env('PASSWORD_UNCOMPROMISED', false),
];