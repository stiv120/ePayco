<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Doctrine\ORM\EntityManagerInterface;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Src\SoapService\WalletTransaction\Domain\Repositories\WalletTransactionRepositoryInterface;
use Src\SoapService\WalletTransaction\Infrastructure\Persistence\DoctrineWalletTransactionRepository;

class WalletTransactionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(EntityManagerInterface::class, function ($app) {
            return EntityManager::getFacadeRoot();
        });

        $this->app->bind(WalletTransactionRepositoryInterface::class, function ($app) {
            $entityManager = $app->make(EntityManagerInterface::class);
            return new DoctrineWalletTransactionRepository($entityManager);
        });
    }

    public function boot()
    {
        //
    }
}
