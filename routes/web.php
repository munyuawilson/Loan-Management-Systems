<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
require __DIR__.'/auth.php';

// Email Verification Routes (protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/dashboard');
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

// Shop Owner Routes (protected)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [ShopController::class, 'dashboard'])->name('shop.dashboard');
    
    // Shop Management
    Route::get('shop/create', [ShopController::class, 'create'])->name('shop.create');
    Route::post('shop', [ShopController::class, 'store'])->name('shop.store');
    Route::get('shop/settings', [ShopController::class, 'settings'])->name('shop.settings');
    Route::put('shop/{shop}', [ShopController::class, 'update'])->name('shop.update');

    // Customer Management
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

   // Loan Management - SPECIFIC ROUTES FIRST
Route::get('/loans/running', [LoanController::class, 'running'])->name('loans.running');
Route::get('/loans/cleared', [LoanController::class, 'cleared'])->name('loans.cleared');
Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');

// PARAMETERIZED ROUTES LAST
Route::get('/loans/{loan}/statement', [LoanController::class, 'statement'])->name('loans.statement');
Route::get('/loans/{loan}/edit', [LoanController::class, 'edit'])->name('loans.edit');
Route::put('/loans/{loan}', [LoanController::class, 'update'])->name('loans.update');
Route::delete('/loans/{loan}', [LoanController::class, 'destroy'])->name('loans.destroy');
Route::get('/loans/{loan}', [LoanController::class, 'show'])->name('loans.show');

    // Payment Management
    Route::get('/loans/{loan}/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/loans/{loan}/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/loans/{loan}/payments/history', [PaymentController::class, 'history'])->name('payments.history');
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');

    // Notification Management
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/loans', [ReportController::class, 'loans'])->name('reports.loans');
    Route::get('/reports/payments', [ReportController::class, 'payments'])->name('reports.payments');
    Route::get('/reports/customers', [ReportController::class, 'customers'])->name('reports.customers');
    Route::post('/reports/export', [ReportController::class, 'export'])->name('reports.export');

    // Profile Routes (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Customer Routes (protected)
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer/dashboard', function () {
        return view('customer.dashboard');
    })->name('customer.dashboard');
    
    Route::get('/customer/loans', [LoanController::class, 'customerLoans'])->name('customer.loans');
    Route::get('/customer/payments', [PaymentController::class, 'customerPayments'])->name('customer.payments');
});

// Fallback route for undefined routes
Route::fallback(function () {
    return redirect()->route('shop.dashboard');
});