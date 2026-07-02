<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProgressCounter extends Model {
    protected $fillable = ['number', 'suffix', 'title', 'icon', 'sort_order', 'active'];

    protected $casts = ['active' => 'boolean'];

    public function scopeActive($query) {
        return $query->where('active', true)->orderBy('sort_order');
    }
}
