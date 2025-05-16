<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestVehicle extends Model
{
    use HasFactory;

    // Daftar atribut yang bisa diisi
    protected $fillable = [
        'plate_number',
        'owner_name',
        'vehicle_type_id', // ganti dari vehicle_model_id
        'entry_time',
        'exit_time',
        'status',
    ];

    // Relasi dengan model VehicleType
    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }
}
