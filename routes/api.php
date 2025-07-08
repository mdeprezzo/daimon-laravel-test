<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\BreweryController;
use App\Http\Controllers\API\LogoutController;

Route::name('api.')->group(function () {
    Route::post('login', LoginController::class)->name('login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('breweries', BreweryController::class)->name('breweries.index');

        Route::post('logout', LogoutController::class)->name('logout');
    });
});
