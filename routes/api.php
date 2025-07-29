<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->group(function () {
    // Define your API routes here

    Route::prefix('auth')->group(function () {
        Route::post('/login', [\App\Http\Controllers\Auth\ApiAuthController::class, 'store']);
        Route::post('/logout', [\App\Http\Controllers\Auth\ApiAuthController::class, 'destroy']);

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


