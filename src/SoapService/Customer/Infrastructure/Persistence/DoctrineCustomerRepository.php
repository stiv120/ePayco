<?php

namespace Src\SoapService\Customer\Infrastructure\Persistence;

use Doctrine\ORM\EntityManagerInterface;
use Src\SoapService\Customer\Domain\Entities\Customer;
use Src\SoapService\Customer\Domain\Repositories\CustomerRepositoryInterface;

class DoctrineCustomerRepository implements CustomerRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Customer $customer)
    {
        $this->entityManager->persist($customer);
        $this->entityManager->flush();
        return true;
    }
}



