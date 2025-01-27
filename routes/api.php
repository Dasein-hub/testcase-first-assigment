<?php

use App\Http\Controllers\CurrencyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(CurrencyController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group( function () {
        Route::get('currencies', 'index');
        Route::get('currency', 'show');
    });

    Route::post('token', 'token');
});
