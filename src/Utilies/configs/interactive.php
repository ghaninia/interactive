<?php

use GhaniniaIR\Interactive\Utilies\Cache\Drivers\{
    FileDriver,
    RedisDriver
};

return [
    'cache' => [
        'default' => 'file',
        'drivers' => [
            FileDriver::driverName() => [
                'extension' => '.txt',
                'ttl' => 3600,
                'cache_dir' => storage_path('interactive-terminal'),
            ],
            RedisDriver::driverName() => [
                'connection_name' => 'interactive',
                'ttl' => 3600
            ]
        ]
    ],
    'route' => [
        'title'  => 'Interactive Terminal',
        'description'  => 'You can run php sentence on Interactive',
        'prefix_name'  => 'interactive',
        'prefix_route' => 'interactive',
        'middlewares' => []
    ],
];

