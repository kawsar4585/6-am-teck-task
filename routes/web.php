<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\FileUploadController;
use App\Http\Controllers\User\OrderController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        return match ($user->role) {
            \App\Models\User::ROLE_ADMIN => redirect()->route('admin.dashboard'),
            \App\Models\User::ROLE_USER => redirect()->route('user.dashboard'),
            default => redirect()->route('login'),
        };
    }
    return redirect()->route('login');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login');

    Route::get('register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('register', [RegisterController::class, 'register'])->name('register');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', [LogoutController::class, 'logout'])->name('logout');

    Route::group(['middleware' => 'checkRole:user', 'prefix' => 'user'], function () {

        Route::get('dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
        Route::get('upload', [FileUploadController::class, 'showForm'])->name('user.upload.form');
        Route::post('upload', [FileUploadController::class, 'upload'])->name('user.upload');
        Route::prefix('orders')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('user.orders.index');
            Route::get('orders/create', [OrderController::class, 'create'])->name('user.orders.create');
            Route::post('orders', [OrderController::class, 'store'])->name('user.orders.store');
        });
    });


    Route::group(['middleware' => 'checkRole:admin','prefix' => 'admin'], function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    });


});
