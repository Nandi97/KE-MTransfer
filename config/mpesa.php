<?php

return [
    'consumer_key' => env('MPESA_CONSUMER_KEY'),
    'consumer_secret' => env('MPESA_CONSUMER_SECRET'),
    'shortcode' => env('MPESA_SHORTCODE'),
    'initiator_name' => env('MPESA_INITIATOR_NAME'),
    'initiator_password' => env('MPESA_INITIATOR_PASSWORD'),
    'base_url' => env('MPESA_BASE_URL'),
    'result_url' => env('MPESA_RESULT_URL'),
    'timeout_url' => env('MPESA_TIMEOUT_URL'),
];
