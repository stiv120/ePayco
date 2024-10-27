<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Doctrine\ORM\EntityManagerInterface;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Src\SoapService\Customer\Domain\Repositories\CustomerRepositoryInterface;
use Src\SoapService\Customer\Infrastructure\Persistence\DoctrineCustomerRepository;

class CustomerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(EntityManagerInterface::class, function ($app) {
            return EntityManager::getFacadeRoot();
        });

        $this->app->bind(CustomerRepositoryInterface::class, function ($app) {
            $entityManager = $app->make(EntityManagerInterface::class);
            return new DoctrineCustomerRepository($entityManager);
        });
    }

    public function boot()
    {
        //
    }
}
