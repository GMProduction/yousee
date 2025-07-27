<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('calon_vendors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_perusahaan');
            $table->string('brand_vendor')->nullable();
            $table->text('alamat')->nullable();
            $table->string('email')->nullable();
            $table->string('nophone');
            $table->string('pic')->nullable();
            $table->string('nomor_pic')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calon_vendors');
    }
};
