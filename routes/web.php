<?php

use Illuminate\Support\Facades\Route;
use Src\SoapService\Customer\Infrastructure\Controllers\CustomerController;

Route::get('/', function () {
    return view('welcome');
});

// Route::post('soap/cliente/registrar', [CustomerController::class, 'registroCliente']);
