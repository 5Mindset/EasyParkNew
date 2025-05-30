<?php



namespace App\Http\Controllers;



use App\Models\Vehicle;

use App\Models\ParkingRecord;

use App\Models\GuestVehicle;

use App\Models\User;

use Illuminate\Support\Carbon;



class DashboardController extends Controller

{

    public function index()

    {

        $today = Carbon::today();



        $totalParkirMahasiswa = ParkingRecord::whereDate('entry_time', $today)->count();

        $totalParkirTamu = GuestVehicle::whereDate('entry_time', $today)->count();



        // Mahasiswa yang parkir hari ini

        $mahasiswaParkir = ParkingRecord::with([

            'vehicle.user',

            'vehicle.model.vehicleBrand',

            'vehicle.model.vehicleType'

        ])

            ->whereDate('entry_time', $today)

            ->where('status', 'parked')

            ->get();



        // Tamu yang parkir hari ini

        $tamuParkir = GuestVehicle::with('vehicleType')

            ->whereDate('entry_time', $today)

            ->where('status', 'parked')

            ->get();



        // Gabungkan data mahasiswa dan tamu

        $parkirHariIni = collect([

            ...$mahasiswaParkir->map(function ($record) {

                return [

                    'tipe' => 'Mahasiswa',

                    'name' => optional($record->vehicle->user)->name,

                    'plat' => optional($record->vehicle)->plate_number,

                    'tipe_kendaraan' => optional($record->vehicle->model->vehicleBrand->vehicleType)->name,

                    'entry_time' => \Carbon\Carbon::parse($record->entry_time)->format('H:i'),

                ];

            }),

            ...$tamuParkir->map(function ($guest) {

                return [

                    'tipe' => 'Tamu',

                    'name' => $guest->name,

                    'plat' => $guest->plate_number,

                    'tipe_kendaraan' => optional($guest->vehicleType)->name,

                    'entry_time' => \Carbon\Carbon::parse($guest->entry_time)->format('H:i'), // â† perbaikan di sini

                ];

            })

        ]);



        return view('admin.dashboard', [

            'totalMahasiswa' => User::where('role', 'mahasiswa')->count(),

            'totalKendaraan' => Vehicle::count(),

            'totalParkirMahasiswa' => $totalParkirMahasiswa,

            'totalParkirTamu' => $totalParkirTamu,

            'parkirHariIni' => $parkirHariIni,

        ]);

    }

}

