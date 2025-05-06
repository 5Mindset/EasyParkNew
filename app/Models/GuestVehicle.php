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
        'vehicle_model_id',
        'entry_time',
        'exit_time',
        'status',
    ];

    // Relasi dengan model VehicleModel
    public function vehicleModel()
    {
        return $this->belongsTo(VehicleModel::class);
    }
}
