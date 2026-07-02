<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faq_section_settings', function (Blueprint $table) {
            $table->id();
            $table->string('sub_title')->default('Got Questions?');
            $table->string('main_title')->default('Frequently Asked Questions');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faq_section_settings');
    }
};
