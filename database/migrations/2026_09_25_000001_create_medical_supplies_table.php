<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Behind-the-scenes inventory of medical supplies
     * (oxygen cylinders, wheelchairs, consumables, ...). Admin-only.
     */
    public function up(): void
    {
        Schema::create('medical_supplies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->default('General');   // Oxygen Cylinder, Wheelchair, ...
            $table->string('unit')->default('units');         // cylinders, pcs, packs, ...
            $table->integer('quantity')->default(0);
            $table->integer('min_quantity')->default(0);      // low-stock threshold
            $table->string('status')->default('available');   // available | maintenance | retired
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_supplies');
    }
};
