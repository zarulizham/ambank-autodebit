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
    'gps_coordinate' => env('AUTODEBIT_GPS_COORDINATE'),

    'table_name' => [
        'bic_codes' => 'auto_debit_bic_codes',
        'callback_transactions' => 'auto_debit_callback_transactions',
        'consents' => 'auto_debit_consents',
        'debit_transactions' => 'auto_debit_debit_transactions',
        'terminations' => 'auto_debit_terminations',
    ],
    'callback' => [
        'path' => 'duitnow-autodebit/callback',
        'name' => 'duitnow-autodebit.callback',
    ],
];
