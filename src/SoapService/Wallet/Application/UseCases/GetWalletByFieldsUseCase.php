<?php

namespace Src\Product\Application\UseCases;

use Src\SoapService\Wallet\Domain\Repositories\WalletRepositoryInterface;

class GetWalletByFieldsUseCase
{
    private $walletRepositoryInterface;

    public function __construct(WalletRepositoryInterface $walletRepositoryInterface)
    {
        $this->walletRepositoryInterface = $walletRepositoryInterface;
    }

    public function execute($fields)
    {
        return $this->walletRepositoryInterface->findByFields($fields);
    }
}
