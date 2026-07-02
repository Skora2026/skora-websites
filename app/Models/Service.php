<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'category_id', 'short_description', 'description', 'image', 'status'];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }
    protected static function boot()
    {
        parent::boot();

        // Jab bhi service create ho
        static::creating(function ($service) {
            $service->slug = Str::slug($service->name);
        });

        // Jab service update ho
        static::updating(function ($service) {
            $service->slug = Str::slug($service->name);
        });
    }
}
