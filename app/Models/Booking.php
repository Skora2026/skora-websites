<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'salutation', 'name', 'phone', 'email', 'address', 'city',
        'state', 'country', 'pincode', 'aadhar_number', 'pan_number',
        'aadhar_front', 'aadhar_back', 'pan_card', 'application_form',
        'cheque_copy', 'point_of_contact', 'manager'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}