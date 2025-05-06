<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    protected $fillable = ['name', 'vehicle_brand_id', 'vehicle_type_id'];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function vehicleBrand()
    {
        return $this->belongsTo(VehicleBrand::class);
    }
    
    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }
}
