<?php

namespace Src\SoapService\WalletTransaction\Infrastructure\Persistence\Factory;

use Faker\Factory as Faker;
use Src\SoapService\WalletTransaction\Domain\Enums\TransactionStatusEnum;
use Src\SoapService\Wallet\Infrastructure\Persistence\Factory\WalletFactory;
use Src\SoapService\WalletTransaction\Infrastructure\Persistence\DoctrineWalletTransactionEntity;

class WalletTransactionFactory
{
    private static $faker;

    public static function create(array $attributes = []): DoctrineWalletTransactionEntity
    {
        self::$faker = Faker::create();
        $em = app('em');

        // Crear una billetera primero si no se proporciona
        if (!isset($attributes['billetera'])) {
            $wallet = WalletFactory::create();
        } else {
            $wallet = $attributes['billetera'];
        }

        $transaction = new DoctrineWalletTransactionEntity();
        $transaction->setBilleteraId($wallet);
        $transaction->setMonto($attributes['monto'] ?? self::$faker->randomFloat(2, 10000, 1000000));
        $transaction->setToken($attributes['token'] ?? self::$faker->numerify('######'));
        $transaction->setSessionId($attributes['session_id'] ?? self::$faker->uuid);
        $transaction->setEstado($attributes['estado'] ?? TransactionStatusEnum::PENDING->value);

        $em->persist($transaction);
        $em->flush();

        return $transaction;
    }
}
