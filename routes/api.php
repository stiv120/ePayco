<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Src\SoapService\Customer\Infrastructure\Controllers\CustomerController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('soap/cliente/registrar', [CustomerController::class, 'registroCliente']);



