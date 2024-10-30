<?php

namespace Src\SoapService\Wallet\Infrastructure\Persistence\Factory;

use Faker\Factory as Faker;
use Src\SoapService\Wallet\Infrastructure\Persistence\DoctrineWalletEntity;

class WalletFactory
{
    private static $faker;

    public static function create(array $attributes = []): DoctrineWalletEntity
    {
        self::$faker = Faker::create();
        $em = app('em');

        $wallet = new DoctrineWalletEntity();
        $wallet->setDocumento($attributes['documento'] ?? self::$faker->unique()->numerify('##########'));
        $wallet->setCelular($attributes['celular'] ?? self::$faker->unique()->numerify('##########'));
        $wallet->setValor($attributes['valor'] ?? self::$faker->randomFloat(2, 10000, 1000000));

        $em->persist($wallet);
        $em->flush();

        return $wallet;
    }
}
