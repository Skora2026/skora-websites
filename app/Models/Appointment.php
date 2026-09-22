<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'service',
        'message',
        'preferred_date',
        'preferred_time',
        'status',
    ];

    protected $casts = [
        'preferred_date' => 'date:Y-m-d',
    ];
}
