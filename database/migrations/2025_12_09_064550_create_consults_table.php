<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('consults', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->json('interests'); 
            $table->string('budget');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('consults');
    }
};