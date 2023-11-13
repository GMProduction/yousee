<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('project_id')->unsigned()->nullable();
            $table->BigInteger('city_id')->unsigned()->nullable();
            $table->bigInteger('pic_id')->unsigned()->nullable();
            $table->bigInteger('item_id')->unsigned()->nullable();
            $table->bigInteger('vendor_price')->default(0);
            $table->timestamps();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('pic_id')->references('id')->on('users');
            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_items');
    }
}
