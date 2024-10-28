<?php

namespace Src\SoapService\Wallet\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Exceptions\CustomJsonException;
use Src\SoapService\Wallet\Infrastructure\Request\StoreWalletRequest;
use Src\SoapService\Wallet\Application\UseCases\RechargeWalletUseCase;

class WalletController extends Controller
{
    private $rechargeWalletUseCase;

    public function __construct(
        RechargeWalletUseCase $rechargeWalletUseCase,
    ) {
        $this->rechargeWalletUseCase = $rechargeWalletUseCase;
    }

    /**
     * Recarga la billetera.
     * @param StoreWalletRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws CustomJsonException si hay un error durante el proceso de creación del recurso.
     */
    public function recargarBilletera(StoreWalletRequest $request)
    {
        $wallet = $this->rechargeWalletUseCase->execute($request->all());
        if (!$wallet) {
            throw new CustomJsonException(
                [
                    'message_error' => 'Error al recargar la billetera.'
                ]
            );
        }
        return response()->json(
                [
                    'success' => true,
                    'data' => [
                        'wallet' => $wallet->jsonSerialize(),
                        'message' => 'Billetera cargada correctamente.'
                    ]
                ],
            201
        );
    }
}
