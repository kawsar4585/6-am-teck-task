<?php

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\User\PostController;
use App\Http\Controllers\Api\V1\User\ProfileController;
use App\Http\Middleware\ApiV1AccessMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware([ApiV1AccessMiddleware::class])->prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('login', [LoginController::class, 'login']);
    });

    Route::middleware(['auth:api','apiCheckRole:user'])->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('profile', [ProfileController::class, 'profile']);

            Route::prefix('posts')->group(function () {
                Route::get('/', [PostController::class, 'index']);
                Route::get('{id}', [PostController::class, 'show']);
                Route::post('/', [PostController::class, 'store']);
                Route::post('{id}/update', [PostController::class, 'update']);
                Route::delete('{id}', [PostController::class, 'destroy']);
            });
        });
    });

});
