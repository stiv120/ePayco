<?php

namespace Src\SoapService\Wallet\Infrastructure\Request;

use App\Http\Requests\FormRequest;
use Src\SoapService\Customer\Application\UseCases\GetCustomerByFieldsUseCase;

class StoreWalletRequest extends FormRequest
{
    private $getCustomerByFieldsUseCase;

    public function __construct(
        GetCustomerByFieldsUseCase $getCustomerByFieldsUseCase
    ) {
        $this->getCustomerByFieldsUseCase = $getCustomerByFieldsUseCase;
    }

    public function rules()
    {
        return [
            'celular' => 'required|string|max:255',
            'valor' => 'required|numeric|min:20000',
            'documento' => 'required|string|max:255'
        ];
    }

    /**
     * Prepare the data for validation.
     * @return void
     */
    protected function passedValidation()
    {
        $this->customerExists();
    }

    /**
     * Check if a customer exists.
     * @return void
     */
    public function customerExists()
    {
        $customerExists = $this->getCustomerByFieldsUseCase->execute(
            [
                'celular' => $this->celular,
                'documento' => $this->documento
            ]
        );
        if (!$customerExists) {
            $this->failedValidation(['Cliente no encontrado!']);
        }
    }

    public function messages()
    {
        return [
            'valor.min' => 'El monto mínimo debe ser 20000',
            'valor.required' => 'El campo valor es requerido',
            'celular.required' => 'El campo celular es requerido',
            'documento.required' => 'El campo documento es requerido'
        ];
    }
}

