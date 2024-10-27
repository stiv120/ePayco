<?php

namespace Src\SoapService\Wallet\Application\UseCases;

use Src\SoapService\Wallet\Domain\Entities\Wallet;
use Src\SoapService\Wallet\Domain\Repositories\WalletRepositoryInterface;

class RegisterWalletUseCase
{
    private $walletRepository;

    public function __construct(WalletRepositoryInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function execute(array $data)
    {
        $wallet = new Wallet($data);
        return $this->walletRepository->save($wallet);
    }
}
