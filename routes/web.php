<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\PemesananController;


Route::get('/', function () {
    return redirect('/backend/login');
});
Route::get('backend/dashboard', [DashboardController::class, 'index'])->name('backend.dashboard');
Route::get('backend/login', [LoginController::class, 'Login'])->name('backend.login');
Route::post('backend/login', [LoginController::class, 'authenticate'])->name('backend.login');
Route::post('backend/logout', [LoginController::class, 'logout'])->name('backend.logout');

// Route::resource('backend/user', UserController::class)->middleware('auth');
Route::resource('backend/user', UserController::class, ['as'=>'backend'])->middleware('auth');
Route::resource('backend/kamar', KamarController::class, ['as'=>'backend'])->middleware('auth');
Route::resource('backend/pemesanan', PemesananController::class, ['as'=>'backend'])->middleware('auth');

Route::middleware(['auth', 'admin'])->prefix('backend')->name('backend.')->group(function () {
   Route::resource('/user', UserController::class);
});

