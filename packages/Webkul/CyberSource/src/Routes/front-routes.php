<?php

use Illuminate\Support\Facades\Route;
use Webkul\CyberSource\Http\Controllers\CyberSourceController;

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency'], 'prefix' => 'checkout'], function () {

    Route::controller(CyberSourceController::class)->group(function () {
        Route::get('redirect/cyber-source', 'redirect')->name('cyber_source.process');

        Route::post('cybersource/response', 'processPayment');

        Route::post('cybersource/cancel', 'cancelPayment');
    });
});

