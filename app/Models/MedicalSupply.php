<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalSupply extends Model
{
    use HasFactory;

    public const CATEGORY_OXYGEN = 'Oxygen Cylinder';
    public const CATEGORY_WHEELCHAIR = 'Wheelchair';

    protected $fillable = [
        'name',
        'category',
        'unit',
        'quantity',
        'min_quantity',
        'status',
        'notes',
    ];

    public function isLowStock(): bool
    {
        return $this->quantity <= $this->min_quantity;
    }
}
