<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('landing', [LandingController::class, 'index']);

// Dashboard
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Transactions
Route::get('transactions/export', [TransactionController::class, 'export'])->name('transactions.export');
Route::resource('transactions', TransactionController::class)->except(['show']);

// Categories
Route::resource('categories', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);

// Reports
Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
