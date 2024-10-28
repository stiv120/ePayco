<?php

namespace Src\SoapService\WalletTransaction\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Exceptions\CustomJsonException;
use Src\SoapService\WalletTransaction\Application\UseCases\PurchasePaymentUseCase;
use Src\SoapService\WalletTransaction\Infrastructure\Request\StoreWalletTransactionRequest;

class WalletTransactionController extends Controller
{
    private $purchasePaymentUseCase;

    public function __construct(
        PurchasePaymentUseCase $purchasePaymentUseCase,
    ) {
        $this->purchasePaymentUseCase = $purchasePaymentUseCase;
    }

    /**
     * Realiza el pago de una compra.
     * @param StoreWalletRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws CustomJsonException si hay un error durante el proceso de creación del recurso.
     */
    public function realizarPagoCompra(StoreWalletTransactionRequest $request)
    {
        $walletTransaction = $this->purchasePaymentUseCase->execute($request->all());
        if (!$walletTransaction) {
            throw new CustomJsonException(
                [
                    'message_error' => 'Error al realizar el pago de la compra.'
                ]
            );
        }
        return response()->json(
                [
                    'success' => true,
                    'data' => [
                        'wallet_transaction' => $walletTransaction->jsonSerialize(),
                        'message' => 'Pago pendiente por confirmar.'
                    ]
                ],
            201
        );
    }
}
