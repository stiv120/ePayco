<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Src\SoapService\Customer\Infrastructure\Controllers\CustomerController;
use Src\SoapService\Wallet\Infrastructure\Controllers\WalletController;
use Src\SoapService\WalletTransaction\Infrastructure\Controllers\WalletTransactionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('soap/clientes/registrar', [CustomerController::class, 'registroCliente']);

Route::prefix('soap/billeteras')->group(function () {
    //Ruta para recargar la billetera
    Route::post('recargar', [WalletController::class, 'recargarBilletera']);
    //Ruta para consultar el saldo de la billetera
    Route::post('consultar-saldo', [WalletController::class, 'consultarSaldo']);

    //Grupo para las transacciones de la billetera
    Route::prefix('transacciones')->group(function () {
        Route::post('realizar-pago', [WalletTransactionController::class, 'realizarPagoCompra']);
        Route::post('confirmar-pago/{transaccion}', [WalletTransactionController::class, 'confirmarPagoCompra']);
    });
});
