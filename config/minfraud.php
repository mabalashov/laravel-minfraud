<?php

return [
    'enabled' => env('MINFRAUD_ENABLED', false),
    
    'account_id' => env('MINFRAUD_ACCOUNT_ID', null),
    'account_key' => env('MINFRAUD_ACCOUNT_KEY', null),

    'max_risk_score' => env('MINFRAUD_MAX_RISK_SCORE', 15),
    'cache_timeout' => env('MINFRAUD_CACHE_TIMEOUT', 60),

    'whitelist_ip' => env('MINFRAUD_WHITELIST_IP', null),
];
