<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Transactions
Route::get('transactions/export', [TransactionController::class, 'export'])->name('transactions.export');
Route::resource('transactions', TransactionController::class)->except(['show']);

// Categories
Route::resource('categories', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);

// Reports
Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
