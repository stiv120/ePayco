<?php

namespace App\Exceptions;

use Exception;

class CustomJsonException extends Exception
{
    protected $data;
    protected $code;
    protected $success;
    protected $message;

    public function __construct($data)
    {
        $this->code = $data['code'] ?? 500;
        $this->data = $data['data'] ?? 'error';
        $this->success = $data['success'] ?? false;
        $this->message = $data['message'] ??  'Error interno del servidor';
    }

    public function render()
    {
        return response()->json([
            'data' => $this->data,
            'cod_error' => $this->code,
            'success' => $this->success,
            'message_error' => $this->message
        ], $this->code);
    }
}
