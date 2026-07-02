<?php

// app/Models/WhyChooseUsSection.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhyChooseUsSection extends Model
{
    protected $table = 'why_choose_us_sections';

    protected $fillable = [
        'sub_title', 'main_title', 'features', 'right_image'
    ];

    protected $casts = [
        'features' => 'array'
    ];
}
