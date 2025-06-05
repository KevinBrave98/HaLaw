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
         Schema::create('pengacaras', function (Blueprint $table) {
            $table->string('nik_pengacara', 16)->primary();
            $table->string('nama_pengacara');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nomor_telepon')->unique();
            $table->string('jenis_kelamin');
            $table->string('lokasi');
            $table->string('spesialisasi');
            $table->integer('tarif_jasa');
            $table->integer('durasi_pengalaman');
            $table->integer('pengalaman_bekerja');
            $table->string('pendidikan');
            $table->string('preferensi_komunikasi');
            $table->string('status_konsultasi');
            $table->string('foto_pengacara');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('pengacara');
    }
};
