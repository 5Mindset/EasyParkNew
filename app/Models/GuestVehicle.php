<?php
// app/Models/GuestVehicle.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestVehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_name',
        'plate_number',
        'vehicle_type_id',
        'entry_time',
        'exit_time',
        'status',
    ];

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }
}
