<?php

namespace Src\SoapService\WalletTransaction\Infrastructure\Listeners;

use Illuminate\Support\Facades\Mail;
use Src\SoapService\Wallet\Application\UseCases\GetWalletByIdUseCase;
use Src\SoapService\Customer\Application\UseCases\GetCustomerByFieldsUseCase;
use Src\SoapService\WalletTransaction\Infrastructure\Mail\TransactionCreatedMail;
use Src\SoapService\WalletTransaction\Domain\Events\WalletTransactionCreatedEvent;

class SendTransactionEmailListener
{
    private $getWalletByIdUseCase;
    private $getCustomerByFieldsUseCase;
    public function __construct(
        GetWalletByIdUseCase $getWalletByIdUseCase,
        GetCustomerByFieldsUseCase $getCustomerByFieldsUseCase
    )
    {
        $this->getWalletByIdUseCase = $getWalletByIdUseCase;
        $this->getCustomerByFieldsUseCase = $getCustomerByFieldsUseCase;
    }

    public function handle(WalletTransactionCreatedEvent $event): void
    {
        $walletTransaction = $event->walletTransaction;
        $wallet = $this->getWalletByIdUseCase->execute($walletTransaction->getBilleteraId());
        $customer = $this->getCustomerByFieldsUseCase->execute(
            [
                'celular' => $wallet->getCelular(),
                'documento' => $wallet->getDocumento()
            ]
        );
        if ($customer->getEmail()) {
            Mail::to($customer->getEmail())->send(
                new TransactionCreatedMail($walletTransaction)
            );
        }
    }
}
