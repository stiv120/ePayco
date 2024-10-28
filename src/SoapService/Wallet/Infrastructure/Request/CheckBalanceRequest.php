<?php

namespace Src\SoapService\Wallet\Infrastructure\Request;

use App\Http\Requests\FormRequest;

class CheckBalanceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'celular' => 'required|string|max:255|exists:billeteras,celular',
            'documento' => 'required|string|max:255|exists:billeteras,documento'
        ];
    }

    public function messages()
    {
        return [
            'celular.required' => 'El celular es requerido',
            'documento.required' => 'El documento es requerido',
            'celular.exists' => 'El celular no coincide con ningún registro',
            'documento.exists' => 'El documento no coincide con ningún registro'
        ];
    }
}

