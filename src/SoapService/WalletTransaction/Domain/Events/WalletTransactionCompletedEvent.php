<?php

namespace Src\SoapService\WalletTransaction\Domain\Events;

use Src\SoapService\WalletTransaction\Domain\Entities\WalletTransaction;

class WalletTransactionCompletedEvent
{
    public function __construct(
        public readonly WalletTransaction $walletTransaction
    ) {}
}
