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
            $table->string('nik_pengacara', 16)->unique();
            $table->string('nik_pengguna', 16)->unique();
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('status');
            $table->string('jenis_layanan');
            $table->integer('penilaian');
            $table->string('ulasan');
            $table->timestamps();

            $table->foreign('nik_pengacara')->references('nik_pengacara')->on('pengacara')->cascadeOnDelete();
            $table->foreign('nik_pengguna')->references('nik_pengguna')->on('pengguna')->cascadeOnDelete();
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
