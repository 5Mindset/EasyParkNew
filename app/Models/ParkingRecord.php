<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'parking_area_id',
        'entry_time',
        'exit_time',
        'status',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function parkingArea()
    {
        return $this->belongsTo(ParkingArea::class);
    }
}
