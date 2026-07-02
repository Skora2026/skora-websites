<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consult extends Model {
    use HasFactory;

    protected $fillable = ['name', 'phone', 'interests', 'budget'];
    protected $casts = [
        'interests' => 'array' 
    ];
    public function budget() {
        return $this->belongsTo(Budget::class);
    }
}