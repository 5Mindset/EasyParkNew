<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VehicleTypeController;
use App\Http\Controllers\Api\VehicleBrandController;
use App\Http\Controllers\Api\VehicleModelController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\GuestVehicleController;
use App\Http\Controllers\Api\ParkingRecordController;
use App\Http\Controllers\Api\VehicleStudentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OtpController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/send-otp', [OtpController::class, 'sendOtp']);
Route::post('/verify-otp', [OtpController::class, 'verifyOtp']);
Route::post('/reset-password', [OtpController::class, 'resetPassword']);
Route::get('/vehicles/{id}', [VehicleController::class, 'show']); // public access

// Routes for authenticated users
Route::middleware('auth:sanctum')->group(function () {
    Route::put('/update-profile', [AuthController::class, 'updateProfile']);
    Route::post('/upload-profile-image', [AuthController::class, 'uploadProfileImage']);
    Route::get('/profile-image', [AuthController::class, 'getProfileImage']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/logout-all', [AuthController::class, 'logoutAll']);
});

// Routes for Admin only
// Routes for Admin & Petugas
Route::middleware(['auth:sanctum', 'roleApi:admin,petugas'])->group(function () {
    Route::apiResource('vehicle-types', VehicleTypeController::class);
    Route::apiResource('vehicle-brands', VehicleBrandController::class);
    Route::apiResource('vehicle-models', VehicleModelController::class);
    Route::apiResource('vehicles', VehicleController::class);
    Route::apiResource('guest-vehicles', GuestVehicleController::class);
    Route::apiResource('parking-records', ParkingRecordController::class);

    // Tambahan baru
    Route::get('parking-records/active', [ParkingRecordController::class, 'active']);

    Route::put('guest-vehicles/{id}/exit', [GuestVehicleController::class, 'exitVehicle']);

    Route::get('/user', function (Request $request) {
        return response()->json(['user' => $request->user()]);
    });
});
// Routes for Mahasiswa only
Route::middleware(['auth:sanctum', 'roleApi:mahasiswa,petugas'])->group(function () {
    Route::apiResource('my-vehicles', VehicleStudentController::class);
    Route::get('/vehicle-types', [VehicleTypeController::class, 'index']);
    Route::get('/vehicle-brands', [VehicleBrandController::class, 'index']);
    Route::get('/vehicle-models', [VehicleModelController::class, 'index']);
    Route::get('/vehicle-brands/by-type/{typeId}', [VehicleBrandController::class, 'getByType']);
    Route::get('/vehicle-models/by-brand/{brandId}', [VehicleModelController::class, 'getByBrand']);
    Route::post('/vehicle-models', [VehicleModelController::class, 'store']);
    Route::post('/my-vehicles/{id}', [VehicleStudentController::class, 'update']); // Tambahkan ini
});
