<?php


use App\Http\Controllers\SuitPayControllers;
use Illuminate\Support\Facades\Route;


Route::prefix('suitpay')
    ->group(function () {
        Route::post('callback', [SuitPayControllers::class, 'callbackMethod']);
        Route::post('payment', [SuitPayControllers::class, 'callbackMethodPayment']);
        Route::get('withdrawal/{id}', [SuitPayControllers::class, 'withdrawalFromModal'])->name('suitpay.withdrawal');
        Route::get('cancelwithdrawal/{id}', [SuitPayControllers::class, 'cancelWithdrawalFromModal'])->name('suitpay.cancelwithdrawal');
    });
