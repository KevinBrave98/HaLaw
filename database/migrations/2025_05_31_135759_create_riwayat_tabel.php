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
         Schema::create('riwayats', function (Blueprint $table) {
            $table->string('id_riwayat')->primary();
            $table->string('nik_pengacara', 16);
            $table->string('nik_pengguna', 16);
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('status');
            $table->string('jenis_layanan');
            $table->integer('penilaian')->nullable();
            $table->string('ulasan')->nullable();
            $table->timestamps();

            $table->foreign('nik_pengacara')->references('nik_pengacara')->on('pengacaras')->cascadeOnDelete();
            $table->foreign('nik_pengguna')->references('nik_pengguna')->on('penggunas')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('riwayat');
    }
};
