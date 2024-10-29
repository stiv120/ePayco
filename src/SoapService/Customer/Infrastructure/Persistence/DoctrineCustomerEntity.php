<?php

namespace Src\SoapService\Customer\Infrastructure\Persistence;

use Doctrine\ORM\Mapping as ORM;
use Src\SoapService\Customer\Domain\Entities\Customer;

#[ORM\Entity]
#[ORM\Table(name: 'clientes')]
class DoctrineCustomerEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string')]
    private $email;

    #[ORM\Column(type: 'string')]
    private $celular;

    #[ORM\Column(type: 'string')]
    private $nombres;

    #[ORM\Column(type: 'string')]
    private $documento;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getCelular(): string
    {
        return $this->celular;
    }

    public function setCelular(string $celular): self
    {
        $this->celular = $celular;
        return $this;
    }

    public function getNombres(): string
    {
        return $this->nombres;
    }

    public function setNombres(string $nombres): self
    {
        $this->nombres = $nombres;
        return $this;
    }

    public function getDocumento(): string
    {
        return $this->documento;
    }

    public function setDocumento(string $documento): self
    {
        $this->documento = $documento;
        return $this;
    }

    public static function fromCustomer(Customer $customer): self
    {
        $entity = new self();
        $entity->setEmail($customer->getEmail());
        $entity->setCelular($customer->getCelular());
        $entity->setNombres($customer->getNombres());
        $entity->setDocumento($customer->getDocumento());
        return $entity;
    }

    public function toCustomer(): Customer
    {
        return new Customer([
            'id' => $this->getId(),
            'email' => $this->getEmail(),
            'celular' => $this->getCelular(),
            'nombres' => $this->getNombres(),
            'documento' => $this->getDocumento()
        ]);
    }
}
