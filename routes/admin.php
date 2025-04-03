<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

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
        Route::resource('categories', CategoryController::class)->except('show');
        Route::controller(CategoryController::class)->group(function () {
            Route::get('categories/details/{id}','details')->name('categories.details');
            Route::get('categories/list',  'list')->name('categories.list');
        });


        Route::resource('products', ProductController::class)->except('show');
        Route::controller(ProductController::class)->group(function () {
            Route::get('products/details/{id}','details')->name('products.details');
            Route::get('products/list',  'list')->name('products.list');
            Route::delete('products/images/delete/{id}',  'destroyImages')->name('products.images.destroy');
        });
    });


});
