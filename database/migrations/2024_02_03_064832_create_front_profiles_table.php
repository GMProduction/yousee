<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrontProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('front_profiles', function (Blueprint $table) {
            $table->id();
            $table->text('head_office_address');
            $table->string('head_office_phone');
            $table->string('head_office_location');
            $table->text('address');
            $table->string('phone');
            $table->string('email');
            $table->string('location');
            $table->text('sort_history');
            $table->string('facebook')->nullable(true)->default(null);
            $table->string('instagram')->nullable(true)->default(null);
            $table->string('tiktok')->nullable(true)->default(null);
            $table->string('whatsapp')->nullable(true)->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('front_profiles');
    }
}
