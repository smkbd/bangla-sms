<?php

use Smkbd\BanglaSms\Provider\Qsms;

return [
    'default' => 'qsms',
    'providers' => [
        'qsms' => [
            'client_id' => 'CLIENT_ID_HERE',
            'api_key' => 'API_KEY_HERE',
            'sender_id' => 'SENDER_ID_HERE',
            'provider' => Qsms::class
        ]
    ],
];
