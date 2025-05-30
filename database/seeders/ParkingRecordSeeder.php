<?php



namespace Database\Seeders;



use App\Models\ParkingRecord;

use App\Models\Vehicle;

use Illuminate\Database\Seeder;

use Illuminate\Support\Carbon;



class ParkingRecordSeeder extends Seeder

{

    public function run(): void

    {

        $vehicle = Vehicle::inRandomOrder()->first();



        if (!$vehicle) {

            $this->command->warn('Belum ada data kendaraan. Seeder ParkingRecord tidak dijalankan.');

            return;

        }



        $entry = Carbon::now()->subHours(rand(1, 6));



        ParkingRecord::create([

            'vehicle_id' => $vehicle->id,

            'entry_time' => $entry,

            'exit_time' => rand(0, 1) ? $entry->copy()->addHours(rand(1, 3)) : null,

            'status' => rand(0, 1) ? 'parked' : 'exited',

        ]);

    }

}

