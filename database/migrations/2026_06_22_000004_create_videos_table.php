<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('video_categories')->onDelete('set null');
            $table->string('title');
            $table->string('thumbnail')->nullable(); // storage path
            $table->string('video_type')->default('youtube'); // youtube / upload
            $table->string('youtube_url')->nullable();
            $table->string('video_file')->nullable(); // storage path when uploaded
            $table->string('status')->default('active');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
