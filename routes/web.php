<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;


Route::middleware('auth:admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});


Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login')->middleware('guest:admin');


// Admin routes
require __DIR__.'/admin.php';

// Company routes
require __DIR__.'/company.php';
