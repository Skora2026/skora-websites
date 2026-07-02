<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    protected $table = 'about_sections';

    protected $fillable = [
        'sub_title', 'title_line1', 'title_line2', 'logo_image',
        'doctor_name', 'doctor_qualification',
        'center_image', 'small_image', 'description', 'quote_text',
        'values', 'features', 'button_text', 'button_link'
    ];

    protected $casts = [
        'values' => 'array',
        'features' => 'array',
    ];
}