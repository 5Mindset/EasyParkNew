<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate_number',
        'vehicle_model_id',
        'user_id',
        'stnk_image',
        'qr_code',
    ];

    public function model()
    {
        return $this->belongsTo(VehicleModel::class, 'vehicle_model_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Brand relasi via model
    public function brand()
    {
        // Karena brand ada di VehicleModel (model), relasi harus melalui join manual atau menggunakan hasOneThrough
        return $this->hasOneThrough(
            VehicleBrand::class,
            VehicleModel::class,
            'id',             // Foreign key on VehicleModel table...
            'id',             // Foreign key on VehicleBrand table...
            'vehicle_model_id',// Local key on Vehicle table...
            'vehicle_brand_id' // Local key on VehicleModel table...
        );
    }

    // VehicleType relasi via brand (melalui model dan brand)
    public function vehicleType()
    {
        return $this->hasOneThrough(
            VehicleType::class,
            VehicleBrand::class,
            'id',             // Foreign key on VehicleBrand table...
            'id',             // Foreign key on VehicleType table...
            'vehicle_model_id',// Local key on Vehicle table...
            'vehicle_type_id'  // Local key on VehicleBrand table...
        )->join('vehicle_models', 'vehicle_models.vehicle_brand_id', '=', 'vehicle_brands.id');
    }

    public function activeParkingRecord()
    {
        return $this->hasOne(ParkingRecord::class)->whereNull('exit_time')->where('status', 'parked');
    }
}
