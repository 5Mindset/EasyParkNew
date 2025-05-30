<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'area_size'];

    public function brands()
    {
        return $this->hasMany(VehicleBrand::class, 'vehicle_type_id');
    }
}
