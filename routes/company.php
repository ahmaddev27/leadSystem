<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Company\AuthController;


// Company Routes
Route::prefix('company')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('company.login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('company.logout');

    Route::middleware('auth:company')->group(function () {
        Route::get('/dashboard', function () {
            return view('company.dashboard');
        })->name('company.dashboard');
    });
});
