<?php

namespace Src\SoapService\WalletTransaction\Infrastructure\Listeners;

use Src\SoapService\Wallet\Application\UseCases\GetWalletByIdUseCase;
use Src\SoapService\Wallet\Domain\Repositories\WalletRepositoryInterface;
use Src\SoapService\WalletTransaction\Domain\Events\WalletTransactionCompletedEvent;

class UpdateWalletBalanceListener
{
    private $getWalletByIdUseCase;
    private $walletRepository;

    public function __construct(
        GetWalletByIdUseCase $getWalletByIdUseCase,
        WalletRepositoryInterface $walletRepository
    ) {
        $this->getWalletByIdUseCase = $getWalletByIdUseCase;
        $this->walletRepository = $walletRepository;
    }

    public function handle(WalletTransactionCompletedEvent $event): void
    {
        $walletTransaction = $event->walletTransaction;
        $wallet = $this->getWalletByIdUseCase->execute($walletTransaction->getBilleteraId());

        if ($wallet) {
            $wallet->setValor($wallet->getValor() - $walletTransaction->getMonto());
            $this->walletRepository->save($wallet);
        }
    }
}
