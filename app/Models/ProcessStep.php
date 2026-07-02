<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProcessStep extends Model {
    protected $fillable = ['title', 'description', 'step_number', 'icon', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($query) {
        return $query->where('is_active', true)->orderBy('step_number');
    }
}
