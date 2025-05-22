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

    public function brand()
    {
        return $this->model?->vehicleBrand;
    }

    public function vehicleType()
    {
        return $this->model?->vehicleBrand?->vehicleType;
    }

    public function activeParkingRecord()
    {
        return $this->hasOne(ParkingRecord::class)->whereNull('exit_time')->where('status', 'parked');
    }
}
