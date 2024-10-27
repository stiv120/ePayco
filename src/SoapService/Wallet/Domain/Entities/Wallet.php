<?php

namespace Src\SoapService\Wallet\Domain\Entities;

class Wallet
{
    private $id;
    private $balance;
    private $clienteId;

    public function __construct($data)
    {
        $this->id = $data['id'] ?? null;
        $this->balance = $data['balance'];
        $this->clienteId = $data['cliente_id'];
    }

    public function obtenerId() {
        return $this->id;
    }

    public function obtenerClienteId() {
        return $this->clienteId;
    }

    public function obtenerBalance() {
        return $this->balance;
    }
}
