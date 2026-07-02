<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoCategory extends Model
{
    protected $fillable = [
        'name',
        'status',
        'sort_order',
    ];

    public function videos()
    {
        return $this->hasMany(Video::class, 'category_id')->orderBy('sort_order');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
