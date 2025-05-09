<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    protected $fillable = ['name'];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function models()
    {
        return $this->hasMany(VehicleModel::class, 'vehicle_type_id');
    }
}
