<?php

use Illuminate\Support\Facades\Route;
use Src\SoapService\Wallet\Infrastructure\Controllers\WalletController;
use Src\SoapService\WalletTransaction\Infrastructure\Controllers\WalletTransactionController;

Route::prefix('soap/billeteras')->group(function () {
    Route::post('recargar', [WalletController::class, 'recargarBilletera']);
    Route::prefix('transacciones')->group(function () {
        Route::post('realizar-pago', [WalletTransactionController::class, 'realizarPagoCompra']);
    });
});
