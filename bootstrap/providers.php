<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\WalletServiceProvider::class,
    App\Providers\CustomerServiceProvider::class,
    LaravelDoctrine\ORM\DoctrineServiceProvider::class,
    App\Providers\WalletTransactionServiceProvider::class
];
