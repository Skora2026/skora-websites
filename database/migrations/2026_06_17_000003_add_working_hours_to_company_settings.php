<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('company_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('company_settings', 'working_hours')) {
                $table->string('working_hours')->nullable()->after('company_description');
            }
        });
    }
    public function down(): void {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->dropColumn('working_hours');
        });
    }
};
