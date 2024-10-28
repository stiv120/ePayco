<?php

namespace Src\SoapService\WalletTransaction\Domain\Enums;

enum TransactionStatusEnum: string
{
    case FAILED = 'fallida';
    case PENDING = 'pendiente';
    case COMPLETED = 'completada';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function default(): string
    {
        return self::PENDING->value;
    }
}
