<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


//===PUBLIC====//
Route::get('/', [PublicController::class, 'index'])->name('welcome');

//===AUTH====//
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/do_login', [AuthController::class, 'do_login'])->name('do_login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/do_register', [AuthController::class, 'do_register'])->name('do_register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


//===ADMIN====//
Route::prefix('/admin')->middleware(['auth', AdminMiddleware::class])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/invoice', [AdminController::class, 'invoice'])->name('invoice');

    Route::resource('invoices', InvoiceController::class);
});

//===BELOVED USERS====//
Route::prefix('app')->middleware(['auth', UserMiddleware::class])->name('app.')->group(function () {
    Route::get('/dashboard', [AppController::class, 'dashboard'])->name('dashboard');
    Route::get('/invoice', [AppController::class, 'invoice'])->name('invoice');
});
