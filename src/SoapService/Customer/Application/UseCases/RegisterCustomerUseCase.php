<?php

namespace Src\SoapService\Customer\Application\UseCases;

use Src\SoapService\Customer\Domain\Entities\Customer;
use Src\SoapService\Customer\Domain\Repositories\CustomerRepositoryInterface;

class RegisterCustomerUseCase
{
    private $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function execute(array $data)
    {
        $customer = new Customer($data);
        return $this->customerRepository->save($customer);
    }
}
