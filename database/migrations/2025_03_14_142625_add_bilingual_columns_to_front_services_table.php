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
        Schema::table('front_services', function (Blueprint $table) {
            $table->string('name_id')->nullable();
            $table->string('name_en')->nullable();
            $table->text('description_id')->nullable();
            $table->text('description_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('front_services', function (Blueprint $table) {
            $table->dropColumn(['name_id', 'name_en', 'description_id', 'description_en']);
        });
    }
};
