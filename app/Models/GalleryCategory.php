<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryCategory extends Model
{
    protected $fillable = [
        'name',
        'status',
        'sort_order',
    ];

    public function images()
    {
        return $this->hasMany(GalleryImage::class, 'category_id')->orderBy('sort_order');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
