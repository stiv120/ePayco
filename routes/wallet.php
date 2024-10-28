<?php

use Illuminate\Support\Facades\Route;
use Src\SoapService\Wallet\Infrastructure\Controllers\WalletController;
use Src\SoapService\WalletTransaction\Infrastructure\Controllers\WalletTransactionController;

//Grupo para las rutas de la billetera
Route::prefix('soap/billeteras')->group(function () {
    //Ruta para recargar la billetera
    Route::post('recargar', [WalletController::class, 'recargarBilletera']);

    //Grupo para las transacciones de la billetera
    Route::prefix('transacciones')->group(function () {
        Route::post('realizar-pago', [WalletTransactionController::class, 'realizarPagoCompra']);
        Route::post('confirmar-pago/{transaccion}', [WalletTransactionController::class, 'confirmarPagoCompra']);
    });
});
