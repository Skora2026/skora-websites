<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('company_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('company_settings', 'office_timings')) {
                $table->json('office_timings')->nullable()->after('working_hours');
            }
        });
    }
    public function down(): void {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->dropColumn('office_timings');
        });
    }
};