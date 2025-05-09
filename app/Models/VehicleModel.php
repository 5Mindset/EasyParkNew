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

    /**
     * Get the brand that this model belongs to.
     */
    public function vehicle_brand()
    {
        return $this->belongsTo(VehicleBrand::class, 'vehicle_brand_id');
    }

    /**
     * Get the type that this model belongs to.
     */
    public function vehicle_type()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }
}
