<?php

namespace Src\SoapService\WalletTransaction\Domain\Repositories;

use Src\SoapService\WalletTransaction\Domain\Entities\WalletTransaction;

interface WalletTransactionRepositoryInterface
{
    public function save(WalletTransaction $walletTransaction);
    public function findById($id);
}
