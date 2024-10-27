<?php

namespace Src\SoapService\Wallet\Infrastructure\Request;

use App\Http\Requests\FormRequest;

class StoreWalletRequest extends FormRequest
{
    public function rules()
    {
        return [
            'balance' => 'required|integer|min:1',
            'cliente_id' => 'required|integer|exists:clientes,id'
        ];
    }
}

