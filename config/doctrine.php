<?php

return [
    'dev_mode' => env('DOCTRINE_DEV_MODE', true),
    'cache_dir' => env('DOCTRINE_CACHE_DIR', null),
    'metadata_dirs' => [
        base_path('src/Customer/Infrastructure/Persistence'),
        base_path('src/Wallet/Infrastructure/Persistence')
    ],
    'connection' => [
        'driver' => env('DB_CONNECTION', 'pdo_mysql'),
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '3306'),
        'dbname' => env('DB_DATABASE', 'forge'),
        'user' => env('DB_USERNAME', 'forge'),
        'password' => env('DB_PASSWORD', ''),
    ],
];
