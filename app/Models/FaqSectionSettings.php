<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqSectionSettings extends Model
{
    protected $table = 'faq_section_settings';

    protected $fillable = [
        'sub_title',
        'main_title',
    ];
}
