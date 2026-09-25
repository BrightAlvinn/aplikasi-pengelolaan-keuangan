<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('landing', [LandingController::class, 'index']);

// Authentication Routes
Route::get('login', fn () => redirect('/?action=login'))->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', fn () => redirect('/?action=register'))->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('auth/google', [AuthController::class, 'googleLogin'])->name('auth.google');

// Protected Dashboard & Financial Management Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Transactions
    Route::get('transactions/export', [TransactionController::class, 'export'])->name('transactions.export');
    Route::resource('transactions', TransactionController::class)->except(['show']);

    // Categories
    Route::resource('categories', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);

    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
});
