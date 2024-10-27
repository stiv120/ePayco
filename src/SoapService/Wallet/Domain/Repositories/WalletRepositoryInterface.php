<?php

namespace Src\SoapService\Wallet\Domain\Repositories;

use Src\SoapService\Wallet\Domain\Entities\Wallet;

interface WalletRepositoryInterface
{
    public function save(Wallet $wallet);
}
