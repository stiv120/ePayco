<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Doctrine\ORM\EntityManagerInterface;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Src\SoapService\Wallet\Domain\Repositories\WalletRepositoryInterface;
use Src\SoapService\Wallet\Infrastructure\Persistence\DoctrineWalletRepository;

class WalletServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(EntityManagerInterface::class, function ($app) {
            return EntityManager::getFacadeRoot();
        });

        $this->app->bind(WalletRepositoryInterface::class, function ($app) {
            $entityManager = $app->make(EntityManagerInterface::class);
            return new DoctrineWalletRepository($entityManager);
        });
    }

    public function boot()
    {
        //
    }
}
