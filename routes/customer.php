<?php

use Illuminate\Support\Facades\Route;
use Src\SoapService\Customer\Infrastructure\Controllers\CustomerController;

Route::post('soap/clientes/registrar', [CustomerController::class, 'registroCliente']);
