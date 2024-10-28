<?php

namespace Src\SoapService\Wallet\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Exceptions\CustomJsonException;
use Src\SoapService\Wallet\Infrastructure\Request\StoreWalletRequest;
use Src\SoapService\Wallet\Application\UseCases\RechargeWalletUseCase;
use Src\SoapService\Wallet\Infrastructure\Request\CheckBalanceRequest;
use Src\SoapService\Wallet\Application\UseCases\GetWalletByFieldsUseCase;

class WalletController extends Controller
{
    private $rechargeWalletUseCase;
    private $getFieldsWalletUseCase;

    public function __construct(
        RechargeWalletUseCase $rechargeWalletUseCase,
        GetWalletByFieldsUseCase $getFieldsWalletUseCase
    ) {
        $this->rechargeWalletUseCase = $rechargeWalletUseCase;
        $this->getFieldsWalletUseCase = $getFieldsWalletUseCase;
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

    /**
     * Consulta el saldo de la billetera.
     * @param CheckBalanceRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws CustomJsonException si hay un error durante la consulta del saldo.
     */
    public function consultarSaldo(CheckBalanceRequest $request)
    {
        $wallet = $this->getFieldsWalletUseCase->execute($request->only('celular', 'documento'));
        if (!$wallet) {
            throw new CustomJsonException(
                [
                    'message_error' => 'Error al consultar el saldo de la billetera.'
                ]
            );
        }
        return response()->json(
            [
                'success' => true,
                'data' => ['saldo' => $wallet->getValor()]
            ],
            200
        );
    }
}
