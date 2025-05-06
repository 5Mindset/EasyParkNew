<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpCode extends Model
{
    protected $fillable = ['email', 'code', 'verified', 'expired_at'];
    protected $casts = [
        'verified' => 'boolean',
        'expired_at' => 'datetime',
    ];
}

