<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_online_sections', function (Blueprint $table) {
           $table->id();
            $table->string('sub_title')->default('Book Online');
            $table->string('main_title')->default('P2GH Booking Engine: Your Dream Property, Just a Click Away');
            $table->text('description_left'); 
            $table->text('description_bottom'); 
            $table->string('gif_image')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_online_sections');
    }
};
