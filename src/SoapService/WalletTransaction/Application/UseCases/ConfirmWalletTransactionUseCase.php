<?php

namespace Src\SoapService\WalletTransaction\Application\UseCases;

use Src\SoapService\WalletTransaction\Domain\Enums\TransactionStatusEnum;
use Src\SoapService\WalletTransaction\Domain\Events\WalletTransactionCompletedEvent;
use Src\SoapService\WalletTransaction\Domain\Repositories\WalletTransactionRepositoryInterface;

class ConfirmWalletTransactionUseCase
{
    private $walletTransactionRepository;

    public function __construct(WalletTransactionRepositoryInterface $walletTransactionRepository)
    {
        $this->walletTransactionRepository = $walletTransactionRepository;
    }

    public function execute($transaccionId)
    {
        $doctrineEntity = $this->walletTransactionRepository
            ->findById($transaccionId);
        $savedTransaction = false;
        if ($doctrineEntity) {
            $doctrineEntity->setEstado(TransactionStatusEnum::COMPLETED);
            $savedTransaction = $this->walletTransactionRepository->save($doctrineEntity);
            if ($savedTransaction) {
                // Disparar evento cuando se confirma la transacción
                event(new WalletTransactionCompletedEvent($savedTransaction));
            }
        }
        return $savedTransaction;
    }
}
