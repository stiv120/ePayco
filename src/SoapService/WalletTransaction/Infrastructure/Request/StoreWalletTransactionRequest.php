<?php

namespace Src\SoapService\WalletTransaction\Infrastructure\Request;

use App\Http\Requests\FormRequest;
use Src\SoapService\WalletTransaction\Application\UseCases\GenerateTokenUseCase;
use Src\SoapService\WalletTransaction\Application\UseCases\GenerateSessionIdUseCase;

class StoreWalletTransactionRequest extends FormRequest
{
    private $generateTokenUseCase;
    private $generateSessionIdUseCase;

    public function __construct(
        GenerateTokenUseCase $generateTokenUseCase,
        GenerateSessionIdUseCase $generateSessionIdUseCase
    ) {
        $this->generateTokenUseCase = $generateTokenUseCase;
        $this->generateSessionIdUseCase = $generateSessionIdUseCase;
    }

    public function rules()
    {
        return [
            'monto' => 'required|numeric|min:20000',
            'billetera_id' => 'required|numeric|exists:billeteras,id'
        ];
    }

    /**
     * Prepare the data for validation.
     * @return void
     */
    protected function passedValidation()
    {
        $this->merge([
            'token' => $this->generateTokenUseCase->execute(),
            'session_id' => $this->generateSessionIdUseCase->execute()
        ]);
    }

    public function messages()
    {
        return [
            'monto.required' => 'El monto es requerido',
            'monto.min' => 'El monto mínimo debe ser 20000',
            'billetera_id.exists' => 'La billetera no existe',
            'billetera_id.required' => 'La billetera es requerida'
        ];
    }
}
