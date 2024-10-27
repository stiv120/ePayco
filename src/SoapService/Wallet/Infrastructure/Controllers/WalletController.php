<?php

namespace Src\SoapService\Wallet\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Exceptions\CustomJsonException;
use Src\SoapService\Wallet\Infrastructure\Request\StoreWalletRequest;
use Src\SoapService\Wallet\Application\UseCases\RegisterWalletUseCase;

class WalletController extends Controller
{
    private $registerWalletUseCase;

    public function __construct(
        RegisterWalletUseCase $registerWalletUseCase
    ) {
        $this->registerWalletUseCase = $registerWalletUseCase;
    }

    /**
     * Recarga la billetera.
     * @param StoreWalletRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws CustomJsonException si hay un error durante el proceso de creación del recurso.
     */
    public function recargarBilletera(StoreWalletRequest $request)
    {
        $wallet = $this->registerWalletUseCase->execute($request->all());
        if (!$wallet) {
            throw new CustomJsonException(['message_error' => 'Error al recargar la billetera.']);
        }
        return response()->json(['success' => 'Billetera cargada correctamente.'], 201);
    }
}

