<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('progress_counters', function (Blueprint $table) {
            if (!Schema::hasColumn('progress_counters', 'suffix')) {
                $table->string('suffix')->nullable()->default('+')->after('number');
            }
            if (!Schema::hasColumn('progress_counters', 'icon')) {
                $table->string('icon')->nullable()->default('bi-graph-up')->after('suffix');
            }
        });
    }
    public function down(): void {
        Schema::table('progress_counters', function (Blueprint $table) {
            $table->dropColumn(['suffix', 'icon']);
        });
    }
};
