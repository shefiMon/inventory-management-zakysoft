<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('/login', [\App\Http\Controllers\Auth\ApiAuthController::class, 'store']);
        Route::post('/logout', [\App\Http\Controllers\Auth\ApiAuthController::class, 'destroy'])->middleware('auth:sanctum');

    });


    Route::prefix('inventory')->group(function () {
        Route::get('/report', [\App\Http\Controllers\InventoryController::class, 'report']);
    });

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::prefix('stock-movement')->group(function () {
            Route::post('/', [\App\Http\Controllers\StockController::class, 'create']);
        });
    });



});


