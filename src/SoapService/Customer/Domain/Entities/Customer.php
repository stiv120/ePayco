<?php

namespace Src\SoapService\Customer\Domain\Entities;

class Customer
{
    private $id;
    private $email;
    private $celular;
    private $nombres;
    private $documento;

    public function __construct(array $datos = [])
    {
        $this->email = $datos['email'];
        $this->id = $datos['id'] ?? null;
        $this->nombres = $datos['nombres'];
        $this->celular = $datos['celular'];
        $this->documento = $datos['documento'];
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'celular' => $this->celular,
            'nombres' => $this->nombres,
            'documento' => $this->documento
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCelular(): string
    {
        return $this->celular;
    }

    public function getNombres(): string
    {
        return $this->nombres;
    }

    public function getDocumento(): string
    {
        return $this->documento;
    }
}
