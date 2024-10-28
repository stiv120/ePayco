<?php

namespace Src\SoapService\WalletTransaction\Infrastructure\Persistence;

use Doctrine\ORM\EntityManagerInterface;
use Src\SoapService\WalletTransaction\Domain\Entities\WalletTransaction;
use Src\SoapService\WalletTransaction\Domain\Events\WalletTransactionCreatedEvent;
use Src\SoapService\WalletTransaction\Domain\Repositories\WalletTransactionRepositoryInterface;
use Src\SoapService\WalletTransaction\Infrastructure\Persistence\DoctrineWalletTransactionEntity;

class DoctrineWalletTransactionRepository implements WalletTransactionRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save($entity)
    {
        if ($entity instanceof WalletTransaction) {
            $doctrineEntity = DoctrineWalletTransactionEntity::fromWalletTransaction($entity);
            $this->entityManager->persist($doctrineEntity);
        } else {
            $doctrineEntity = $entity;
        }

        $this->entityManager->flush();
        return $doctrineEntity->toWalletTransaction();
    }

    public function findById($id)
    {
        return $this->entityManager
            ->getRepository(DoctrineWalletTransactionEntity::class)
            ->find($id);
    }

    public function findByFields($fields)
    {
        return $this->entityManager
            ->getRepository(DoctrineWalletTransactionEntity::class)
            ->findOneBy($fields);
    }
}
