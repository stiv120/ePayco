<?php

namespace Src\SoapService\Wallet\Application\UseCases;

use Src\SoapService\Wallet\Domain\Entities\Wallet;
use Src\SoapService\Wallet\Domain\Repositories\WalletRepositoryInterface;

class RechargeWalletUseCase
{
    private $walletRepository;

    public function __construct(WalletRepositoryInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function execute(array $data)
    {
        $doctrineEntity = $this->walletRepository->findByFields([
            'celular' => $data['celular'],
            'documento' => $data['documento']
        ]);

        $entityToSave = $doctrineEntity
            ? tap($doctrineEntity, fn($entity) => $entity->setValor($entity->getValor() + $data['valor']))
            : new Wallet($data);

        return $this->walletRepository->save($entityToSave);
    }
}
