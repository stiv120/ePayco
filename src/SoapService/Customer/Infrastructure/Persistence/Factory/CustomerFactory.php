<?php

namespace Src\SoapService\Customer\Infrastructure\Persistence\Factory;

use Faker\Factory as Faker;
use Src\SoapService\Customer\Infrastructure\Persistence\DoctrineCustomerEntity;

class CustomerFactory
{
    private static $faker;

    public static function create(array $attributes = []): DoctrineCustomerEntity
    {
        self::$faker = Faker::create();
        $em = app('em');

        $customer = new DoctrineCustomerEntity();
        $customer->setNombres($attributes['nombres'] ?? self::$faker->name);
        $customer->setDocumento($attributes['documento'] ?? self::$faker->unique()->numerify('##########'));
        $customer->setCelular($attributes['celular'] ?? self::$faker->unique()->numerify('##########'));
        $customer->setEmail($attributes['email'] ?? self::$faker->unique()->safeEmail);

        $em->persist($customer);
        $em->flush();

        return $customer;
    }
}
