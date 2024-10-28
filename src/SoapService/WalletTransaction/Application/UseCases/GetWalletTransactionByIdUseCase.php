<?php

namespace Src\SoapService\WalletTransaction\Application\UseCases;

use Src\SoapService\WalletTransaction\Domain\Repositories\WalletTransactionRepositoryInterface;

class GetWalletTransactionByIdUseCase
{
    private $walletTransactionRepositoryInterface;

    public function __construct(WalletTransactionRepositoryInterface $walletTransactionRepositoryInterface)
    {
        $this->walletTransactionRepositoryInterface = $walletTransactionRepositoryInterface;
    }

    public function execute($id)
    {
        $doctrineEntity = $this->walletTransactionRepositoryInterface->findById($id);
        return $doctrineEntity ? $doctrineEntity->toWalletTransaction() : null;
    }
}
