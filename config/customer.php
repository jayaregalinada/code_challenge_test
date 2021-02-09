<?php

return [
    'importer_default_driver' => env('IMPORTER_DRIVER', 'json'),

    'importer_drivers' => [
        'json' => [
            'driver' => 'json',
            'url' => 'https://randomuser.me/api/',
            'version' => '1.3',
            'nationalities' => [
                'au'
            ],
            'fields' => [
                'name',
                'email',
                'login',
                'gender',
                'location',
                'phone',
            ],
            'count' => 50
        ],
        'xml' => [
            'driver' => 'xml',
            'url' => 'https://randomuser.me/api/',
            'version' => '1.3',
            'nationalities' => [
                'au'
            ],
            'fields' => [
                'name',
                'email',
                'login',
                'gender',
                'location',
                'phone',
            ],
            'count' => 50
        ]
    ]
];
