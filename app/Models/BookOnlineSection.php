<?php

// app/Models/BookOnlineSection.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookOnlineSection extends Model
{
    protected $table = 'book_online_sections';

    protected $fillable = [
        'sub_title', 'main_title', 'description_left', 'description_bottom', 'gif_image'
    ];
}