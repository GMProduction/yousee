<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('calon_vendors', function (Blueprint $table) {
            $table->string('titik_file')->nullable();
        });
    }

    public function down()
    {
        Schema::table('calon_vendors', function (Blueprint $table) {
            $table->dropColumn('titik_file');
        });
    }
};
