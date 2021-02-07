<?php

return [
    'importer_default_driver' => env('IMPORTER_DRIVER', 'default'),

    'importer_drivers' => [
        'default' => [
            'driver' => 'default',
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
