<?php

namespace Src\SoapService\WalletTransaction\Infrastructure\Request;

use App\Http\Requests\FormRequest;
use Src\SoapService\WalletTransaction\Domain\Enums\TransactionStatusEnum;
use Src\SoapService\WalletTransaction\Application\UseCases\GetWalletTransactionByIdUseCase;

class ConfirmWalletTransactionRequest extends FormRequest
{
    private $getWalletTransactionByIdUseCase;

    public function __construct(
        GetWalletTransactionByIdUseCase $getWalletTransactionByIdUseCase
    ) {
        $this->getWalletTransactionByIdUseCase = $getWalletTransactionByIdUseCase;
    }

    public function rules()
    {
        return [
            'token' => 'required|string|exists:transacciones_billeteras,token|max:6',
            'session_id' => 'required|string|exists:transacciones_billeteras,session_id'
        ];
    }

    protected function passedValidation()
    {
        $walletTransaction = $this->walletTransactionExists();
        $this->validateTransactionStatus($walletTransaction);
    }

    public function walletTransactionExists()
    {
        $walletTransactionExists = $this->getWalletTransactionByIdUseCase
            ->execute($this->route('transaccion'));
        if (!$walletTransactionExists) {
            $this->failedValidation(['Transacción no encontrada o ha caducado!']);
        }
        return $walletTransactionExists;
    }

    private function validateTransactionStatus($walletTransaction)
    {
        if ($walletTransaction->getEstado()->value !== TransactionStatusEnum::PENDING->value) {
            $this->failedValidation([
                "La transacción ya ha sido procesada con estado: {$walletTransaction->getEstado()->value}"
            ]);
        }
    }

    public function messages()
    {
        return [
            'token.required' => 'El token es requerido',
            'token.max' => 'El token debe ser máximode 6 dígitos',
            'session_id.required' => 'El id de sesión es requerido',
            'token.exists' => 'El token no coincide con el registrado en la transacción.',
            'session_id.exists' => 'El id de sesión no coincide con el registrado en la transacción.'
        ];
    }
}
