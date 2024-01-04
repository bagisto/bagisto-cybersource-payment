<?php

use Illuminate\Support\Facades\Route;
use Webkul\CyberSource\Http\Controllers\CyberSourceController;

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency'], 'prefix' => 'checkout/cybersource'], function () {
    Route::controller(CyberSourceController::class)->group(function () {
        Route::get('cyber-source/redirect', 'redirect')->name('cyber_source.process');

        Route::post('response', 'processPayment');

        Route::post('cancel', 'cancelPayment');
    });
});

