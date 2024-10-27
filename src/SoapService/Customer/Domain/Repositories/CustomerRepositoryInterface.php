<?php

namespace Src\SoapService\Customer\Domain\Repositories;

use Src\SoapService\Customer\Domain\Entities\Customer;

interface CustomerRepositoryInterface
{
    public function save(Customer $customer);
}


