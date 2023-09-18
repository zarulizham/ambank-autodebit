<?php

// config for ZarulIzham/AutoDebit
return [
    'url' => env('AUTODEBIT_URL', 'https://amgatewayuat.ambg.com.my'),
    'client_id' => env('AUTODEBIT_CLIENT_ID'),
    'client_secret' => env('AUTODEBIT_CLIENT_SECRET'),
    'token_expiry' => env('AUTODEBIT_TOKEN_EXPIRY', 3600),
    'channel_token' => env('AUTODEBIT_CHANNEL_TOKEN'),
    'prefix_id' => env('AUTODEBIT_PREFIX_ID'),
    'api_key' => env('AUTODEBIT_API_KEY'),
    'api_secret' => env('AUTODEBIT_API_SECRET'),
    'merchant_id' => env('AUTODEBIT_MERCHANT_ID'),
    'product_id' => env('AUTODEBIT_PRODUCT_ID'),

    'table_name' => [
        'bic_codes' => 'autodebit_bic_codes',
        'callback_transactions' => 'autodebit_callback_transactions',
        'registrations' => 'autodebit_registrations',
        'debit_transactions' => 'autodebit_debit_transactions',
    ],
    'callback' => [
        'path' => 'duitnow-autodebit/callback',
        'name' => 'duitnow-autodebit.callback',
    ],
];
