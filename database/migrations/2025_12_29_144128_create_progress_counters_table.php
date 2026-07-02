<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

   public function up()
    {
        Schema::create('progress_counters', function (Blueprint $table) {
            $table->id();
            $table->string('number'); 
            $table->string('title');
            $table->integer('sort_order')->default(0); 
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('progress_counters');
    }
};
