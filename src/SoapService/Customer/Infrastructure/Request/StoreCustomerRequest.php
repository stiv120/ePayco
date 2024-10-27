<?php

namespace Src\SoapService\Customer\Infrastructure\Request;

use App\Http\Requests\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $reglasString = 'required|string|max:255';
        return [
            'email' => "{$reglasString}|email|unique:clientes,email",
            'nombres' => $reglasString,
            'celular' => $reglasString,
            'documento' => "{$reglasString}|unique:clientes,documento"
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'Debe ser un email válido.',
            'email.required' => 'El campo email es requerido',
            'nombres.required' => 'El campo nombres es requerido',
            'celular.required' => 'El campo celular es requerido',
            'email.unique' => 'Ya existe un cliente con este email.',
            'documento.required' => 'El campo documento es requerido',
            'documento.unique' => 'Ya existe un cliente con este documento.'
        ];
    }
}
