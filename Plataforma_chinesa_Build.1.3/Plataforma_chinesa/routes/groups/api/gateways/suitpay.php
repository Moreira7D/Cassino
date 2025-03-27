<?php

use App\Http\Controllers\SuitPayControllers;
use App\Http\Controllers\Api\Wallet\DepositController;
use Illuminate\Support\Facades\Route;

Route::prefix('suitpay')
    ->group(function () {
        Route::post('qrcode-pix', [SuitPayControllers::class, 'getQRCodePix']);
        Route::post('consult-status-transaction', [DepositController::class, 'consultStatusTransactionPix']);
    });
