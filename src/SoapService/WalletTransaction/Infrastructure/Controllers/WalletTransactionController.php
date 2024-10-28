<?php

namespace Src\SoapService\WalletTransaction\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Exceptions\CustomJsonException;
use Src\SoapService\WalletTransaction\Application\UseCases\PurchasePaymentUseCase;
use Src\SoapService\WalletTransaction\Infrastructure\Request\StoreWalletTransactionRequest;
use Src\SoapService\WalletTransaction\Application\UseCases\ConfirmWalletTransactionUseCase;
use Src\SoapService\WalletTransaction\Infrastructure\Request\ConfirmWalletTransactionRequest;

class WalletTransactionController extends Controller
{
    private $purchasePaymentUseCase;
    private $confirmWalletTransactionUseCase;
    public function __construct(
        PurchasePaymentUseCase $purchasePaymentUseCase,
        ConfirmWalletTransactionUseCase $confirmWalletTransactionUseCase,
    ) {
        $this->purchasePaymentUseCase = $purchasePaymentUseCase;
        $this->confirmWalletTransactionUseCase = $confirmWalletTransactionUseCase;
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
                        'message' => 'Pago pendiente por confirmar, al correo fueron enviados los datos para confirmar el pago, por favor revisa tu correo.'
                    ]
                ],
            201
        );
    }

    public function confirmarPagoCompra(ConfirmWalletTransactionRequest $request, $transaccionId)
    {
        $walletTransaction = $this->confirmWalletTransactionUseCase->execute($transaccionId);
        if (!$walletTransaction) {
            throw new CustomJsonException(
                [
                    'message_error' => 'Error al confirmar el pago de la compra.'
                ]
            );
        }
        return response()->json(
                [
                    'success' => true,
                    'data' => [
                        'wallet_transaction' => $walletTransaction->jsonSerialize(),
                        'message' => 'Pago confirmado.'
                    ]
                ],
            201
        );
    }
}
