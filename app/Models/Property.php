<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;

    protected $casts = [
        'images' => 'array', 
        'location_details' => 'array',
        'amenities' => 'array',
        'financial_details' => 'array',
        'additional_info' => 'array',
        'agent_details' => 'array',
        'parking' => 'boolean',
        'price' => 'decimal:2',
         'listed_date' => 'date',
    ];

    protected $fillable = [
        'project_id', 'title','building_name','logo', 'slug', 'type', 'status', 'price',
        'property_id', 'area_sqft', 'bedrooms', 'bathrooms', 'furnishing',
        'parking', 'property_age', 'location_details','map', 'images', 'description',
        'amenities', 'financial_details', 'additional_info', 'agent_details',
        'video_url', 'floor_plan_image', 'listed_date', 'sale_type','property_listing_status'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }



    public function getLocationDetailsTextAttribute()
    {
        $locations = $this->location_details;

        if (is_string($locations)) {
            $locations = json_decode($locations, true);
        }

        if (is_string($locations)) {
            $locations = json_decode($locations, true);
        }

        return is_array($locations)
            ? implode(', ', $locations)
            : '';
    }

    
}   