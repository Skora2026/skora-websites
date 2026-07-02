<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
   protected $table = 'testimonials';

    protected $fillable = [
        'client_name', 'message', 'rating', 'client_image','background_image', 'sort_order', 'active'
    ];
}
