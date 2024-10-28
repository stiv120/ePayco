<?php

namespace Src\SoapService\WalletTransaction\Application\UseCases;

use Src\SoapService\WalletTransaction\Domain\Entities\WalletTransaction;
use Src\SoapService\WalletTransaction\Domain\Events\WalletTransactionCreatedEvent;
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
        $saveWalletTransaction = $this->walletTransactionRepository->save($walletTransaction);
        if ($saveWalletTransaction) {
            event(new WalletTransactionCreatedEvent($saveWalletTransaction));
        }
        return $saveWalletTransaction;
    }
}
