<?php

namespace Src\SoapService\WalletTransaction\Application\UseCases;

class GenerateTokenUseCase
{
    public function execute(): string
    {
        // Generar token numérico de 6 dígitos
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }
}
