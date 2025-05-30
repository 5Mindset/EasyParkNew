<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <- import ini
use Illuminate\Database\Eloquent\Model;

class ParkingArea extends Model
{
    use HasFactory; // <- pakai trait ini

    protected $fillable = ['name', 'max_area'];

    public function parkingRecords()
    {
        return $this->hasMany(ParkingRecord::class);
    }
}
