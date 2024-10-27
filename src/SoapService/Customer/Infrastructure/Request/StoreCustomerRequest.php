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
            'email' => "{$reglasString}|email",
            'nombres' => $reglasString,
            'celular' => $reglasString,
            'documento' => $reglasString
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'Debe ser un email válido.',
            'email.required' => 'El campo email es requerido',
            'nombres.required' => 'El campo nombres es requerido',
            'celular.required' => 'El campo celular es requerido',
            'documento.required' => 'El campo documento es requerido'
        ];
    }
}
