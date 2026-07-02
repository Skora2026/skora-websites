<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cta_sections', function (Blueprint $table) {
            $table->id();
            $table->string('heading');
            $table->text('description');
            $table->string('button_text')->default('About more');
            $table->string('button_link')->default('#');
            $table->string('background_image'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cta_sections');
    }

    
};
