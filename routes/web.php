<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\CustomerDashboardController;

Route::get('/', function () {
    return view('landingpage');
});

Route::post('/save-design', [DesignController::class, 'save']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('login/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('login/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');



    // Admin routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    });

    // Staff routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/staff/dashboard', [StaffDashboardController::class, 'staffDashboard'])->name('staff.dashboard');
    });

    // Customer routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/customer/dashboard', [CustomerDashboardController::class, 'customerDashboard'])->name('customer.dashboard');
    });
