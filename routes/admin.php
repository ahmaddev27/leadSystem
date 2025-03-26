<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\CategoryController;

// Admin Routes

Route::prefix('admin')->as('admin.')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'showLoginForm')->name('login')->middleware('guest:admin');
        Route::post('/login', 'login')->name('login')->middleware('guest:admin');
        Route::post('/logout', 'logout')->name('logout')->middleware('auth:admin');
    });


// Protected routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', function () {return view('admin.dashboard');})->name('dashboard');
        Route::resource('categories', CategoryController::class);

    });


});
