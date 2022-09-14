<?php

return [
    'cache' => [
        'default' => 'file',
        'drivers' => [
            'file' => [
                'extension' => '.txt',
                'ttl' => 3600,
                'cache_dir' => storage_path('interactive-terminal'),
            ],
            'redis' => [
                'connection_name' => 'interactive'  ,
                'ttl' => 3600 ,
                //"connection" => [
                //    'host' => env('REDIS_HOST', '127.0.0.1'),
                //    'password' => env('REDIS_PASSWORD'),
                //    'port' => env('REDIS_PORT', 6379),
                //    'database' => env('REDIS_DB', 0),
                //]
            ]
        ]
    ] ,
    'route' => [
        'prefix_name'  => 'interactive' ,
        'prefix_route' => 'interactive' ,
    ]
];



