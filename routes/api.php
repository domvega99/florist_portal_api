<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\FloristController;
use App\Http\Controllers\FloristRepController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TownController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')
    ->prefix('v1')
    ->group(function () {
        // Authentication routes
        Route::post('/login', [AuthController::class, 'login']);
        
        Route::middleware(['auth:sanctum', 'role:!Florist'])->group(function () {
            // Authentication routes
            Route::post('/logout', [AuthController::class, 'logout']);
            // User routes
            Route::apiResource('users', UserController::class);
            // Florist routes
            Route::apiResource('florists', FloristController::class);
            // Page routes
            Route::apiResource('pages', PageController::class);
            // Town routes
            Route::apiResource('towns', TownController::class);
            // Province routes
            Route::apiResource('provinces', ProvinceController::class);
            // Collection routes
            Route::apiResource('collections', CollectionController::class);
            // Status routes
            Route::apiResource('statuses', StatusController::class);
            // FloristRep routes
            Route::apiResource('florist_reps', FloristRepController::class);
        });
    }
);



