<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('herobanners', function (Blueprint $table) {
            if (!Schema::hasColumn('herobanners', 'heading')) {
                $table->string('heading')->nullable()->after('title');
            }
            if (!Schema::hasColumn('herobanners', 'subheading')) {
                $table->string('subheading')->nullable()->after('heading');
            }
            if (!Schema::hasColumn('herobanners', 'description')) {
                $table->text('description')->nullable()->after('subheading');
            }
            if (!Schema::hasColumn('herobanners', 'btn_text')) {
                $table->string('btn_text')->nullable()->default('Book Appointment')->after('description');
            }
        });
    }
    public function down(): void {
        Schema::table('herobanners', function (Blueprint $table) {
            $table->dropColumn(['heading', 'subheading', 'description', 'btn_text']);
        });
    }
};