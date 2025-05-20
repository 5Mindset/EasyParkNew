<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\VehicleType;

class VehicleModel extends Model
{
    protected $fillable = [
        'name',
        'vehicle_brand_id',
    ];


    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function vehicleBrand()
    {
        return $this->belongsTo(VehicleBrand::class, 'vehicle_brand_id');
    }

    public function vehicleType()
    {
        return $this->hasOneThrough(VehicleType::class, VehicleBrand::class, 'id', 'id', 'vehicle_brand_id', 'vehicle_type_id');
    }
}
