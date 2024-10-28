<?php

namespace Src\SoapService\WalletTransaction\Infrastructure\Persistence;

use Doctrine\ORM\Mapping as ORM;
use Src\SoapService\WalletTransaction\Domain\Entities\WalletTransaction;
use Src\SoapService\WalletTransaction\Domain\Enums\TransactionStatusEnum;

#[ORM\Entity]
#[ORM\Table(name: 'transacciones_billeteras')]
class DoctrineWalletTransactionEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(name: 'billetera_id', type: 'integer')]
    private $billeteraId;

    #[ORM\Column(type: 'string', length: 6)]
    private $token;

    #[ORM\Column(name: 'session_id', type: 'string', unique: true)]
    private $sessionId;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 8)]
    private $monto;

    #[ORM\Column(type: 'string')]
    private $estado = 'pendiente';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBilleteraId(): int
    {
        return $this->billeteraId;
    }

    public function setBilleteraId(int $billeteraId): self
    {
        $this->billeteraId = $billeteraId;
        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    public function setSessionId(?string $sessionId): self
    {
        $this->sessionId = $sessionId;
        return $this;
    }

    public function getMonto(): float
    {
        return $this->monto;
    }

    public function setMonto(float $monto): self
    {
        $this->monto = $monto;
        return $this;
    }

    public function getEstado(): TransactionStatusEnum
    {
        return TransactionStatusEnum::from($this->estado);
    }

    public function setEstado(TransactionStatusEnum|string $estado): self
    {
        $this->estado = is_string($estado) ? $estado : $estado?->value;
        return $this;
    }

    public static function fromWalletTransaction(WalletTransaction $walletTransaction): self
    {
        $entity = new self();
        $entity->setToken($walletTransaction->getToken());
        $entity->setMonto($walletTransaction->getMonto());
        $entity->setEstado($walletTransaction->getEstado());
        $entity->setSessionId($walletTransaction->getSessionId());
        $entity->setBilleteraId($walletTransaction->getBilleteraId());
        return $entity;
    }

    public function toWalletTransaction(): WalletTransaction
    {
        return new WalletTransaction([
            'id' => $this->getId(),
            'token' => $this->getToken(),
            'monto' => $this->getMonto(),
            'estado' => $this->getEstado(),
            'session_id' => $this->getSessionId(),
            'billetera_id' => $this->getBilleteraId()
        ]);
    }
}
