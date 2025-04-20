<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FloristController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')
    ->prefix('v1')
    ->group(function () {
        // Authentication routes
        Route::post('/login', [AuthController::class, 'login']);


            // Authentication routes
            Route::post('/logout', [AuthController::class, 'logout']);
            // User routes
            Route::apiResource('users', UserController::class)->middleware('role:Administrator');
            // Florist routes
            Route::apiResource('florists', FloristController::class);
            Route::get('florists-cities', [FloristController::class, 'getCities']);
            Route::get('florists-provinces', [FloristController::class, 'getProvinces']);
            Route::get('florists-statuses', [FloristController::class, 'getStatuses']);
            Route::get('florists-representatives', [FloristController::class, 'getFloristReps']);
     
    }
);



