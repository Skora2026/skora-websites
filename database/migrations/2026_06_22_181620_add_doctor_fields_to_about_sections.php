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
    Schema::table('about_sections', function (Blueprint $table) {
        $table->string('doctor_name')->nullable()->after('logo_image');
        $table->string('doctor_qualification')->nullable()->after('doctor_name');
    });
}

public function down(): void
{
    Schema::table('about_sections', function (Blueprint $table) {
        $table->dropColumn(['doctor_name', 'doctor_qualification']);
    });
}
};
