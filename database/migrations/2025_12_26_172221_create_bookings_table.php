<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('salutation'); 
            $table->string('name');
            $table->string('phone', 15);
            $table->string('email');
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('pincode', 20);
            $table->string('aadhar_number', 12);
            $table->string('pan_number', 10);
            $table->string('aadhar_front')->nullable(); // path to file
            $table->string('aadhar_back')->nullable();
            $table->string('pan_card')->nullable();
            $table->string('application_form')->nullable();
            $table->string('cheque_copy')->nullable();
            $table->string('point_of_contact')->nullable();
            $table->string('manager');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};