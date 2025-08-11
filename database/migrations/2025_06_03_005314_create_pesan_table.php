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
        Schema::create('pesan', function (Blueprint $table) {
            $table->string('id_pesan')->primary();
            $table->string('id_riwayat')->unique();
            $table->string('nik', 16);
            $table->dateTime('waktu_pesan');
            $table->string('teks');
            $table->timestamps();

            $table->foreign('id_riwayat')->references('id_riwayat')->on('riwayat')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesan');
    }
};
