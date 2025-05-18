<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    protected $fillable = ['name', 'area_size'];

    public function brands()
    {
        return $this->hasMany(VehicleBrand::class, 'vehicle_type_id');
    }
}
