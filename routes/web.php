<?php

use App\Http\Controllers\VehicleTypeController;
use App\Http\Controllers\VehicleBrandController;
use App\Http\Controllers\VehicleModelController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ProfileController1;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GuestVehicleController;
use App\Http\Controllers\ParkingRecordController;
use App\Http\Controllers\ParkingAreaController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing/index');
});

// Dashboard untuk Admin (hanya bisa diakses oleh user yang sudah login dan verified)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Menambahkan middleware untuk role admin pada route resource
Route::middleware(['auth', 'roleWeb:admin'])->group(function () {
    Route::resource('vehicle-types', VehicleTypeController::class);
    Route::resource('vehicle-brands', VehicleBrandController::class);
    Route::resource('vehicle-models', VehicleModelController::class);
    Route::resource('vehicles', VehicleController::class);
    Route::resource('officers', OfficerController::class);
    Route::resource('students', StudentController::class);
    Route::resource('guest-vehicles', GuestVehicleController::class);
    Route::resource('parking-records', ParkingRecordController::class);
    Route::resource('parking-areas', ParkingAreaController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController1::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController1::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController1::class, 'update'])->name('profile.update');

    // 👇 Tambahkan ini untuk edit dan update password
    Route::get('/profile/password', [ProfileController1::class, 'editPassword'])->name('profile.password.edit');
    Route::put('/profile/password', [ProfileController1::class, 'updatePassword'])->name('profile.updatePassword');
});

require __DIR__ . '/auth.php';
