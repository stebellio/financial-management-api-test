<?php

declare(strict_types=1);

return [
    'api-tools-content-negotiation' => [
        'selectors' => [],
    ],
    'router'                        => [
        'routes' => [
            'oauth' => [
                'options' => [
                    'spec'  => '%oauth%',
                    'regex' => '(?P<oauth>(/oauth))',
                ],
                'type'    => 'regex',
            ],
        ],
    ],
    'api-tools-mvc-auth'            => [
        'authentication' => [
            'map' => [
                'FinalcialManagement\\V1' => 'auth',
            ],
        ],
    ],
    'db'                            => [
        'driver'   => PDO::class,
        'adapters' => [
            'default.adapter' => [
                'driver' => PDO::class,
                'dsn'    => 'sqlite:data/dbtest.sqlite',
            ],
        ],
    ],
];
