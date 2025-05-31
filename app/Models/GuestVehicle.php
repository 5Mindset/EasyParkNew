<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestVehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'plate_number',
        'vehicle_type_id',
        'parking_area_id', // ditambahkan
        'entry_time',
        'exit_time',
        'status',
    ];

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function parkingArea()
    {
        return $this->belongsTo(ParkingArea::class);
    }
}
