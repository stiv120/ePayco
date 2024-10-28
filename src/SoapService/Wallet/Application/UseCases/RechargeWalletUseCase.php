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
        $existingWallet = $this->walletRepository->findByFields(
            [
                'celular' => $data['celular'],
                'documento' => $data['documento']
            ]
        );

        if ($existingWallet) {
            $existingWallet->valor = $existingWallet->valor + $data['valor'];
        }
        $wallet = $existingWallet ?? new Wallet($data);
        return $this->walletRepository->save($wallet);
    }
}
