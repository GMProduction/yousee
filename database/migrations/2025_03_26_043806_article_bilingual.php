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
            $table->string('title_id')->nullable()->after('title');
            $table->string('title_en')->nullable()->after('title_id');
            $table->text('content_id')->nullable()->after('content');
            $table->text('content_en')->nullable()->after('content_id');
        });

        DB::statement("UPDATE front_articles SET title_id = title, content_id = content");
        DB::statement("UPDATE front_articles SET title_en = title_id, content_en = content_id");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('front_articles', function (Blueprint $table) {
            $table->dropColumn(['title_id', 'title_en', 'content_id', 'content_en']);
        });
    }
};
