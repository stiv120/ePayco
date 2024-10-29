<?php

namespace Src\SoapService\Wallet\Infrastructure\Persistence;

use Doctrine\ORM\Mapping as ORM;
use Src\SoapService\Wallet\Domain\Entities\Wallet;

#[ORM\Entity]
#[ORM\Table(name: 'billeteras')]
class DoctrineWalletEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 8)]
    private $valor;

    #[ORM\Column(type: 'string')]
    private $documento;

    #[ORM\Column(type: 'string')]
    private $celular;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValor(): float
    {
        return $this->valor;
    }

    public function setValor(float $valor): self
    {
        $this->valor = $valor;
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

    public function getCelular(): string
    {
        return $this->celular;
    }

    public function setCelular(string $celular): self
    {
        $this->celular = $celular;
        return $this;
    }

    public static function fromWallet(Wallet $wallet): self
    {
        $entity = new self();
        $entity->setValor($wallet->getValor());
        $entity->setCelular($wallet->getCelular());
        $entity->setDocumento($wallet->getDocumento());
        return $entity;
    }

    public function toWallet(): Wallet
    {
        return new Wallet([
            'id' => $this->getId(),
            'valor' => $this->getValor(),
            'celular' => $this->getCelular(),
            'documento' => $this->getDocumento()
        ]);
    }
}
