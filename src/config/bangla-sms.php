<?php

use Smkbd\BanglaSms\Provider\Smsq;
use Smkbd\BanglaSms\Provider\SmsNoc;

return [
    'default' => 'smsq',
    'providers' => [
        'smsq' => [
            'client_id' => 'CLIENT_ID_HERE',
            'api_key' => 'API_KEY_HERE',
            'sender_id' => 'SENDER_ID_HERE',
            'provider' => Smsq::class
        ],
        'smsnoc' => [
            'sender_id' => 'SENDER_ID_HERE',
            'token' => 'TOKEN_HERE',
            'provider' => SmsNoc::class
        ]
    ],
];
