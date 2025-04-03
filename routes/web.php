<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return redirect()->route('home');
});


Route::get('/link', function () {
    Artisan::call('storage:link');
});




Route::middleware('auth:admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});


Route::get('login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest:admin');


// Admin routes
require __DIR__.'/admin.php';

// Company routes
require __DIR__.'/company.php';

