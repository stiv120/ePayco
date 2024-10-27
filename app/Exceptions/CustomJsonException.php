<?php

namespace App\Exceptions;

use Exception;

class CustomJsonException extends Exception
{
    protected $data;
    protected $cod_error;
    protected $message_error;

    public function __construct($data)
    {
        $this->data = $data['data'] ?? 'error';
        $this->cod_error = $data['cod_error'] ?? 500;
        $this->message_error = $data['message_error'] ??  'Error interno del servidor';
    }

    public function render()
    {
        return response()->json([
            $this->data => $this->message_error,
        ], $this->cod_error);
    }
}
