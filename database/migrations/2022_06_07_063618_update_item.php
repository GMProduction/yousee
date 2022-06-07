<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            //
            $table->bigInteger('city_id')->unsigned()->nullable(true);
            $table->foreign('city_id')->references('id')->on('cities');
            $table->text('location')->nullable(true)->default(null);
            $table->text('url')->nullable(true)->default(null);
            $table->bigInteger('type_id')->unsigned()->nullable(true);
            $table->foreign('type_id')->references('id')->on('types');
            $table->enum('position',['Vertical','Horizontal'])->default('Vertical');
            $table->integer('width')->default(0);
            $table->integer('height')->default(0);
            $table->text('image1')->nullable(true)->default(null);
            $table->text('image2')->nullable(true)->default(null);
            $table->text('image3')->nullable(true)->default(null);
            $table->bigInteger('created_by')->unsigned()->nullable(true);
            $table->foreign('created_by')->references('id')->on('users');
            $table->dropColumn('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            //
        });
    }
}
