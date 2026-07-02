<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('herobanners', function (Blueprint $table) {
            $table->string('badge_text')->nullable()->after('btn_text');
            $table->string('btn2_text')->nullable()->after('badge_text');
            $table->string('floating_title')->nullable()->after('btn2_text');
            $table->string('floating_subtitle')->nullable()->after('floating_title');
        });
    }

    public function down(): void
    {
        Schema::table('herobanners', function (Blueprint $table) {
            $table->dropColumn(['badge_text', 'btn2_text', 'floating_title', 'floating_subtitle']);
        });
    }
};