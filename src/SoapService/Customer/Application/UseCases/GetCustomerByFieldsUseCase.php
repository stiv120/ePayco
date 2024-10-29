<?php

namespace Src\SoapService\Customer\Application\UseCases;

use Src\SoapService\Customer\Domain\Repositories\CustomerRepositoryInterface;

class GetCustomerByFieldsUseCase
{
    private $customerRepositoryInterface;

    public function __construct(CustomerRepositoryInterface $customerRepositoryInterface)
    {
        $this->customerRepositoryInterface = $customerRepositoryInterface;
    }

    public function execute($fields)
    {
        return $this->customerRepositoryInterface->findByFields($fields);
    }
}
