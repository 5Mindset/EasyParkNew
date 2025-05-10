<?php

use App\Http\Controllers\VehicleTypeController;
use App\Http\Controllers\VehicleBrandController;
use App\Http\Controllers\VehicleModelController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing/index');
});

// Dashboard untuk Admin (hanya bisa diakses oleh user yang sudah login dan verified)
Route::get('/dashboard', function () {
    return view('admin/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Menambahkan middleware untuk role admin pada route resource
Route::middleware(['auth', 'roleWeb:admin'])->group(function () {
    Route::resource('vehicle-types', VehicleTypeController::class);
    Route::resource('vehicle-brands', VehicleBrandController::class);
    Route::resource('vehicle-models', VehicleModelController::class);
    Route::resource('vehicles', VehicleController::class);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Route untuk halaman profil pengguna (biasa)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
