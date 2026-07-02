<?php
// Migration: php artisan make:migration create_company_settings_table
// database/migrations/xxxx_create_company_settings_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('company_settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('company_short_name')->nullable();
            $table->string('company_tagline')->nullable();
            $table->text('company_description')->nullable();
            $table->string('light_logo')->nullable(); // File path
            $table->string('footer_images')->nullable(); // File path
            $table->string('favicon')->nullable(); // File path
            $table->string('company_email1')->nullable();
            $table->string('company_email2')->nullable();
            $table->string('company_mobile1')->nullable();
            $table->string('company_mobile2')->nullable();
            $table->string('company_whatsapp1')->nullable();
            $table->string('company_whatsapp2')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable(); // Labeled as YouTube in form
            $table->string('instagram')->nullable();
            $table->string('pintrest')->nullable();
            $table->text('map')->nullable(); // Google Map Link
            $table->text('company_address1')->nullable();
            $table->text('company_address2')->nullable();
            $table->string('currency_name')->nullable();
            $table->string('currency_symbol')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('company_settings');
    }
};