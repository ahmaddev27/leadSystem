<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Company\AuthController as CompanyAuthController;


// Company Routes
Route::prefix('company')->group(function () {
    Route::get('/login', [CompanyAuthController::class, 'showLoginForm'])->name('company.login');
    Route::post('/login', [CompanyAuthController::class, 'login']);
    Route::post('/logout', [CompanyAuthController::class, 'logout'])->name('company.logout');

    Route::middleware('auth:company')->group(function () {
        Route::get('/dashboard', function () {
            return view('company.dashboard');
        })->name('company.dashboard');
    });
});
