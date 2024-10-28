<?php

namespace Src\SoapService\WalletTransaction\Application\UseCases;

use Ramsey\Uuid\Uuid;

class GenerateSessionIdUseCase
{
    public function execute(): string
    {
        return Uuid::uuid4()->toString();
    }
}
