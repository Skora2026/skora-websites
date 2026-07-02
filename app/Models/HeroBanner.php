<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class HeroBanner extends Model {
    protected $table = 'herobanners';
    protected $fillable = [
        'title', 'heading', 'subheading', 'description', 'btn_text', 'btn2_text',
        'badge_text', 'floating_title', 'floating_subtitle',
        'move_text', 'image'
    ];
}