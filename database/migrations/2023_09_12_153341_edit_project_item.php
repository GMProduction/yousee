<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditProjectItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_items', function (Blueprint $table) {
            //
            $table->bigInteger('vendor_price')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_items', function (Blueprint $table) {
            //
            $table->bigInteger('vendor_price')->nullable(false)->change();
        });
    }
}
