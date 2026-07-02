<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about_sections', function (Blueprint $table) {
            $table->string('small_image')->nullable()->after('center_image');
            $table->text('quote_text')->nullable()->after('description');
            $table->json('values')->nullable()->after('quote_text');
        });
    }

    public function down(): void
    {
        Schema::table('about_sections', function (Blueprint $table) {
            $table->dropColumn(['small_image', 'quote_text', 'values']);
        });
    }
};
