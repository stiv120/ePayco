<?php

namespace Src\Product\Application\UseCases;

use Src\SoapService\Wallet\Domain\Repositories\WalletRepositoryInterface;

class GetWalletByIdUseCase
{
    private $walletRepositoryInterface;

    public function __construct(WalletRepositoryInterface $walletRepositoryInterface)
    {
        $this->walletRepositoryInterface = $walletRepositoryInterface;
    }

    public function execute($id)
    {
        return $this->walletRepositoryInterface->findById($id);
    }
}
