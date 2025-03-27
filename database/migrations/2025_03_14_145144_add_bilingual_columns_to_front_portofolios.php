<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('front_portofolios', function (Blueprint $table) {
            $table->string('name_id')->nullable()->after('name');
            $table->string('name_en')->nullable()->after('name_id');
            $table->text('description_id')->nullable()->after('description');
            $table->text('description_en')->nullable()->after('description_id');
        });

        DB::statement("UPDATE front_portofolios SET name_id = name, description_id = description");
        DB::statement("UPDATE front_portofolios SET name_en = name_id, description_en = description_id");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('front_portofolios', function (Blueprint $table) {
            $table->dropColumn(['name_id', 'name_en', 'description_id', 'description_en']);
        });
    }
};
