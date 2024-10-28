<?php

namespace Src\SoapService\Wallet\Domain\Entities;

class Wallet
{
    private $id;
    private $valor;
    private $celular;
    private $documento;

    public function __construct($data)
    {
        $this->id = $data['id'] ?? null;
        $this->celular = $data['celular'];
        $this->valor = $data['valor'] ?? 0;
        $this->documento = $data['documento'];
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'valor' => $this->valor,
            'celular' => $this->celular,
            'documento' => $this->documento
        ];
    }

    public function getId() {
        return $this->id;
    }

    public function getDocumento() {
        return $this->documento;
    }

    public function getValor() {
        return $this->valor;
    }

    public function getCelular(): string
    {
        return $this->celular;
    }
}
