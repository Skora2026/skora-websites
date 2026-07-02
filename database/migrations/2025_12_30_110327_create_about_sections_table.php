<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();
            $table->string('sub_title')->default('About us');
            $table->string('title_line1'); 
            $table->string('title_line2'); 
            $table->string('logo_image')->nullable(); 
            $table->string('center_image'); 
            $table->text('description');
            $table->string('button_text')->default('About more');
            $table->string('button_link')->default('about.php');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('about_sections');
    }
};