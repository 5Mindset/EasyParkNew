<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleBrand;
use App\Models\VehicleType;

class VehicleBrandSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
    'Motor' => [
        'Honda Motor',
        'Yamaha',
        'Kawasaki',
        'Suzuki Motor',
        'Benelli',
        'KTM',
        'TVS',
        'BMW Motor',
        'Viar',
        'Vespa',
        'Royal Enfield',
        'Ducati',
        'Triumph',
        'Bajaj',
        'SYM',
        'Harley Davidson',
        'Husqvarna',
        'Cleveland CycleWerks',
        'MV Agusta',
        'Kymco',
        'Aprilia',
        'Piaggio',
        'Peugeot Motor',
        'Moto Guzzi',
        'Diablo',
        'Gesits',
        'SM Sport',
        'ECGO',
        'United',
        'Selis',
        'BF Goodrich',
        'Qooder',
        'Royal Alloy',
        'Italjet',
        'Keeway',
        'Volta',
        'Alva',
        'Segway',
        'Treeletrik',
        'Polytron Motor',
        'Charged',
        'Yadea',
        'Scomadi',
        'LISGO',
        'Savart',
        'KOOL',
        'Wmoto',
        'CFMoto',
        'Rakata Motorcycle',
        'Vmove',
        'ION Mobility',
        'ZPT',
        'Pacific',
        'Uwinfly',
        'Maka',
        'INDOMOBIL eMOTOR',
        'QJ Motor',
        'Benda',
        'Sunra',
    ],
    'Mobil' => [
        'Toyota',
        'Daihatsu',
        'Honda Mobil',
        'Mitsubishi',
        'Suzuki Mobil',
        'Hyundai',
        'Wuling',
        'Kia',
        'BMW Mobil',
        'Mazda',
        'Isuzu',
        'Mercedes Benz',
        'Nissan',
        'DFSK',
        'Renault',
        'Volkswagen',
        'Lexus',
        'Jeep',
        'Land Rover',
        'Audi',
        'Tata',
        'MINI',
        'Peugeot Mobil',
        'Lamborghini',
        'Porsche',
        'Ferrari',
        'Aston Martin',
        'Mclaren',
        'Jaguar',
        'Rolls Royce',
        'Volvo',
        'Maserati',
        'Bentley',
        'Fiat',
        'Ford',
        'Geely',
        'Subaru',
        'Tesla',
        'Mahindra',
        'MG',
        'Maxus',
        'CHERY',
        'Citroen',
        'ESEMKA',
        'Neta',
        'GWM',
        'BYD',
        'VinFast',
        'BAIC',
        'GAC',
        'Jetour',
        'JAECOO',
        'ZEEKR',
        'ALETRA',
        'Honri',
        'Polytron Mobil',
    ],
        ];

        foreach ($data as $vehicleTypeName => $brands) {
            $vehicleType = VehicleType::where('name', $vehicleTypeName)->first();

            if (!$vehicleType) {
                continue;
            }

            foreach ($brands as $brandName) {
                VehicleBrand::firstOrCreate(
                    ['name' => $brandName],
                    ['vehicle_type_id' => $vehicleType->id]
                );
            }
        }
    }
}
