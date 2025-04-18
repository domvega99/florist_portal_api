<?php

use App\Http\Controllers\FloristController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('api')
    ->prefix('v1')
    ->group(function () {
        Route::apiResource('florists', FloristController::class);
        Route::get('florists-cities', [FloristController::class, 'getCities']);
        Route::get('florists-provinces', [FloristController::class, 'getProvinces']);
        Route::get('florists-statuses', [FloristController::class, 'getStatuses']);
        Route::get('florists-representatives', [FloristController::class, 'getFloristReps']);
    });

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

