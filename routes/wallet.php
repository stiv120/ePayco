<?php

use Illuminate\Support\Facades\Route;
use Src\SoapService\Wallet\Infrastructure\Controllers\WalletController;

Route::prefix('soap/billeteras')->group(function () {
    Route::post('recargar', [WalletController::class, 'recargarBilletera']);
});
