<?php

namespace Src\SoapService\WalletTransaction\Application\UseCases;

use Src\SoapService\WalletTransaction\Domain\Entities\WalletTransaction;
use Src\SoapService\WalletTransaction\Domain\Repositories\WalletTransactionRepositoryInterface;

class PurchasePaymentUseCase
{
    private $walletTransactionRepository;

    public function __construct(WalletTransactionRepositoryInterface $walletTransactionRepository)
    {
        $this->walletTransactionRepository = $walletTransactionRepository;
    }

    public function execute(array $data)
    {
        $walletTransaction = new WalletTransaction($data);
        return $this->walletTransactionRepository->save($walletTransaction);
    }
}
