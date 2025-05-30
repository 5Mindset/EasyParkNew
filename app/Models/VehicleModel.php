<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // ? Tambahkan ini
use App\Models\VehicleType;

class VehicleModel extends Model
{
    use HasFactory; // ? Tambahkan ini

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
        return $this->hasOneThrough(
            VehicleType::class,
            VehicleBrand::class,
            'id',                  // foreign key on VehicleBrand
            'id',                  // foreign key on VehicleType
            'vehicle_brand_id',    // local key on VehicleModel
            'vehicle_type_id'      // local key on VehicleBrand
        );
    }
}
