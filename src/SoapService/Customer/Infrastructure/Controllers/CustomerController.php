<?php

namespace Src\SoapService\Customer\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Exceptions\CustomJsonException;
use Src\SoapService\Customer\Infrastructure\Request\StoreCustomerRequest;
use Src\SoapService\Customer\Application\UseCases\RegisterCustomerUseCase;

class CustomerController extends Controller
{
    private $registerCustomerUseCase;

    public function __construct(
        RegisterCustomerUseCase $registerCustomerUseCase
    ) {
        $this->registerCustomerUseCase = $registerCustomerUseCase;
    }

    /**
     * Registra un nuevo cliente.
     * @param StoreCustomerRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws CustomJsonException si hay un error durante el proceso de creación del cliente.
     */
    public function registroCliente(StoreCustomerRequest $request)
    {
        $customer = $this->registerCustomerUseCase->execute($request->all());
        if (!$customer) {
            throw new CustomJsonException(
                [
                    'message_error' => 'Error al registrar al cliente.'
                ]
            );
        }
        return response()->json(
                [
                    'success' => true,
                    'data' => [
                        'customer' => $customer->jsonSerialize(),
                        'message' => 'Cliente registrado correctamente.'
                    ]
                ],
            201
        );
    }
}
