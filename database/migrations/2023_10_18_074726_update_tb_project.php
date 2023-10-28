<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTbProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            //
            $table->dropColumn('duration_unit');
        });
        Schema::table('projects', function (Blueprint $table) {
            //
            $table->enum('duration_unit', ['Hari', 'Minggu', 'Bulan', 'Tahun'])->default('Bulan');
            $table->string('offer_number')->default(null)->nullable();
            $table->tinyInteger('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            //
            $table->enum('duration_unit', ['day', 'week', 'month', 'year'])->default('month');
            $table->dropColumn('offer_number');
            $table->dropColumn('status');
        });
    }
}
