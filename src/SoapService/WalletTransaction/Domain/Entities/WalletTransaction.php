<?php

namespace Src\SoapService\WalletTransaction\Domain\Entities;

use JsonSerializable;
use Src\SoapService\WalletTransaction\Domain\Enums\TransactionStatusEnum;

class WalletTransaction implements JsonSerializable
{
    private ?int $id;
    private int $billeteraId;
    private ?string $token;
    private ?string $sessionId;
    private float $monto;
    private TransactionStatusEnum $estado;

    public function __construct(array $data)
    {
        $this->monto = $data['monto'];
        $this->id = $data['id'] ?? null;
        $this->token = $data['token'] ?? null;
        $this->billeteraId = $data['billetera_id'];
        $this->sessionId = $data['session_id'] ?? null;
        $this->estado = is_string($data['estado'] ?? null)
            ? TransactionStatusEnum::from($data['estado'])
            : ($data['estado'] ?? TransactionStatusEnum::PENDING);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBilleteraId(): ?int
    {
        return $this->billeteraId;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    public function getMonto(): float
    {
        return $this->monto;
    }

    public function getEstado(): TransactionStatusEnum
    {
        return $this->estado;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'billetera_id' => $this->billeteraId,
            'token' => $this->token,
            'session_id' => $this->sessionId,
            'monto' => $this->monto,
            'estado' => $this->estado->value
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
