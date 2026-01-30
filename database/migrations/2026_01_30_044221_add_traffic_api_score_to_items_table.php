<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            // 1. Tambah traffic_api_score (INT, Default 0)
            // Catatan: Pastikan nama kolom sebelumnya benar 'trafic' (sesuai prompt Anda) atau 'traffic'
            $table->integer('traffic_api_score')
                ->default(0)
                ->after('trafic');

            // 2. Tambah traffic_last_updated (TIMESTAMP, NULL)
            $table->timestamp('traffic_last_updated')
                ->nullable()
                ->after('traffic_api_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            // Hapus kedua kolom jika rollback
            $table->dropColumn(['traffic_api_score', 'traffic_last_updated']);
        });
    }
};
