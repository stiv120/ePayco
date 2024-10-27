<?php

namespace Src\SoapService\Customer\Domain\Entities;

class Customer
{
    public $email;
    public $celular;
    public $nombres;
    public $documento;

    public function __construct(array $datos)
    {
        $this->email = $datos['email'];
        $this->nombres = $datos['nombres'];
        $this->celular = $datos['celular'];
        $this->documento = $datos['documento'];
    }
}
