<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MainController;

Route::middleware('guest')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('login', 'login');
    });

Route::middleware('auth:sanctum')
    ->controller(MainController::class)
    ->group(function () {
        Route::group(['prefix' => 'stock'], function () {
            Route::post('/transfer', 'transfer');
            Route::post('/refill', 'refill');
            Route::post('/order', 'order');
        });
        Route::group(['prefix' => 'warehouses'], function () {
            Route::get('/', 'warehouses');
            Route::get('/{warehouse}/stock', 'stock');
        });
        Route::get('/stock-log', 'stock_log');
    });
