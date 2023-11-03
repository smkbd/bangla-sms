<?php

use Smkbd\BanglaSms\Provider\Smsq;

return [
    'default' => 'smsq',
    'providers' => [
        'smsq' => [
            'client_id' => 'CLIENT_ID_HERE',
            'api_key' => 'API_KEY_HERE',
            'sender_id' => 'SENDER_ID_HERE',
            'provider' => Smsq::class
        ]
    ],
];
