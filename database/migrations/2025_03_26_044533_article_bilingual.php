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
        Schema::table('front_articles', function (Blueprint $table) {
            Schema::table('front_articles', function (Blueprint $table) {
                $table->string('sort_desc_id')->nullable()->after('title');
                $table->string('sort_desc_en')->nullable()->after('title_id');
            });

            DB::statement("UPDATE front_articles SET sort_desc_id = sort_desc");
            DB::statement("UPDATE front_articles SET sort_desc_en = sort_desc_id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('front_articles', function (Blueprint $table) {
            //
        });
    }
};
