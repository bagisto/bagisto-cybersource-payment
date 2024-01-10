<?php

use Illuminate\Support\Facades\Route;
use Webkul\CyberSource\Http\Controllers\CyberSourceController;

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency'], 'prefix' => 'checkout/cyber-source'], function () {
    Route::controller(CyberSourceController::class)->group(function () {
        Route::get('redirect', 'redirect')->name('cyber_source.redirect');

        Route::post('response', 'processPayment');

        Route::post('cancel', 'cancelPayment');
    });
});

