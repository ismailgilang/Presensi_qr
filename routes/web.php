<?php

use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\PresensiUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('User', UserController::class);
    Route::resource('Barcode', BarcodeController::class);
    Route::resource('Presensi', PresensiController::class);
    Route::resource('Presensi2', PresensiUserController::class);
});

require __DIR__ . '/auth.php';
