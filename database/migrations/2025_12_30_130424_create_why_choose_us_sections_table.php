<?php
// database/migrations/xxxx_create_why_choose_us_sections_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('why_choose_us_sections', function (Blueprint $table) {
            $table->id();
            $table->string('sub_title')->default('Why Choose Us');
            $table->string('main_title')->default('Why P2GH Stands Out');
            $table->json('features'); 
            $table->string('right_image'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('why_choose_us_sections');
    }
};