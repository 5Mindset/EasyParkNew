<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\ParkingRecordMahasiswa;
use App\Models\ParkingRecordTamu;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin/dashboard', [
            'totalMahasiswa' => User::where('role', 'mahasiswa')->count(),
            'totalKendaraan' => Vehicle::count(),
            // 'totalParkirMahasiswa' => ParkingRecordMahasiswa::count(),
            // 'totalParkirTamu' => \App\Models\ParkingRecordTamu::count(),
            'recentVehicles' => Vehicle::latest()->take(5)->get(),
            'chartLabels' => ['Jan', 'Feb', 'Mar', 'Apr'], // contoh, bisa dinamis
            'chartData' => [10, 14, 6, 20], // isi dari query real
        ]);
    }
}
