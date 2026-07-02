<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade'); 
            $table->string('title'); 
            $table->string('building_name');
            $table->string('logo')->nullable();
            $table->string('slug')->unique(); 
            $table->enum('type', ['Apartment', 'Villa', 'Independent House', 'Plot'])->default('Apartment');
            $table->enum('status', ['Ready To Move', 'Under Construction', 'New Launch'])->default('Ready To Move');
            $table->decimal('price', 10, 2); 
            $table->string('property_id')->unique();
            $table->integer('area_sqft');
            $table->integer('bedrooms')->default(0);
            $table->integer('bathrooms')->default(0);
            $table->enum('furnishing', ['Furnished', 'Semi-furnished', 'Unfurnished'])->default('Semi-furnished');
            $table->boolean('parking')->default(false);
            $table->integer('property_age')->default(0); 
            $table->json('location_details')->nullable(); 
            $table->text('map')->nullable(); 
            $table->json('images')->nullable(); 
            $table->text('description')->nullable();
            $table->json('amenities')->nullable(); 
            $table->json('financial_details')->nullable();
            $table->json('additional_info')->nullable();
            $table->json('agent_details')->nullable(); 
            $table->string('video_url')->nullable();
            $table->string('floor_plan_image')->nullable();
            $table->date('listed_date')->nullable();
            $table->enum('sale_type', ['For Sale', 'For Rent'])->default('For Sale');
            $table->timestamps();
            $table->softDeletes(); 
            $table->index(['project_id', 'status']); 
            $table->index('slug'); 
            $table->index('price'); 
            $table->enum('property_listing_status', ['top Property', 'list on banner'])->default('top Property');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};