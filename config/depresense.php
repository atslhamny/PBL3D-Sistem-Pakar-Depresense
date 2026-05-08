<?php

return [
    'safety' => [
        'item_number'  => env('SAFETY_ITEM_NUMBER', 9),
        'threshold'    => env('SAFETY_THRESHOLD', 2),
        'hotline'      => env('HOTLINE_NUMBER', '119 ext 8'),
    ],
    'bdi' => [
        'total_questions' => 21,
        'max_score'       => 42,
        'max_cognitive'   => 26,
        'max_somatic'     => 16,
    ],
    'session' => [
        'timeout_minutes' => 30,
        'guest_ttl_hours' => 24,
    ],
    'privacy' => [
        'k_anonymity_min' => 5,
    ],
];
