<?php

namespace Src\SoapService\WalletTransaction\Domain\Events;

use Src\SoapService\WalletTransaction\Domain\Entities\WalletTransaction;

class WalletTransactionCreatedEvent
{
    public function __construct(
        public readonly WalletTransaction $walletTransaction
    ) {}
}
