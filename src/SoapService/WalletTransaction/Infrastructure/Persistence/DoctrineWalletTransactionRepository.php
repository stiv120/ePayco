<?php

namespace Src\SoapService\WalletTransaction\Infrastructure\Persistence;

use Doctrine\ORM\EntityManagerInterface;
use Src\SoapService\WalletTransaction\Domain\Entities\WalletTransaction;
use Src\SoapService\WalletTransaction\Domain\Repositories\WalletTransactionRepositoryInterface;
use Src\SoapService\WalletTransaction\Domain\Events\WalletTransactionCreatedEvent;

class DoctrineWalletTransactionRepository implements WalletTransactionRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(WalletTransaction $walletTransaction)
    {
        $doctrineEntity = DoctrineWalletTransactionEntity::fromWalletTransaction($walletTransaction);
        $this->entityManager->persist($doctrineEntity);
        $this->entityManager->flush();
        $this->entityManager->refresh($doctrineEntity);

        // Disparar evento de dominio
        event(new WalletTransactionCreatedEvent($doctrineEntity->toWalletTransaction()));

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
