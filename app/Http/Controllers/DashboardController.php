<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\ParkingRecord;
use App\Models\GuestVehicle;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin/dashboard', [
            'totalMahasiswa' => User::where('role', 'mahasiswa')->count(),
            'totalKendaraan' => Vehicle::count(),
            'totalParkirMahasiswa' => ParkingRecord::count(),
            'totalParkirTamu' => GuestVehicle::count(),
        ]);
    }
}
