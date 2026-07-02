<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Old 'amenities' table only stored a name (no image, no real gallery use).
        // Replaced fully by gallery_categories + gallery_images.
        Schema::dropIfExists('amenities');
    }

    public function down(): void
    {
        Schema::create('amenities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }
};
