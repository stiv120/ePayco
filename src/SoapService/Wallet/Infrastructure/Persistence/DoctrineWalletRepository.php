<?php

namespace Src\SoapService\Wallet\Infrastructure\Persistence;

use Doctrine\ORM\EntityManagerInterface;
use Src\SoapService\Wallet\Domain\Entities\Wallet;
use Src\SoapService\Wallet\Domain\Repositories\WalletRepositoryInterface;

class DoctrineWalletRepository implements WalletRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save($wallet)
    {
        if ($wallet instanceof Wallet) {
            $doctrineEntity = DoctrineWalletEntity::fromWallet($wallet);
            $this->entityManager->persist($doctrineEntity);
        } else {
            $doctrineEntity = $wallet;
        }
        $this->entityManager->flush();
        return $doctrineEntity->toWallet();
    }

    public function findById($id)
    {
        return $this->entityManager
            ->getRepository(DoctrineWalletEntity::class)
            ->find($id);
    }

    public function findByFields($fields)
    {
        return $this->entityManager
            ->getRepository(DoctrineWalletEntity::class)
            ->findOneBy($fields);
    }
}
