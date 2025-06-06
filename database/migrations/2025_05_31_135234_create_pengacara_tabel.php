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
            $table->string('jenis_kelamin')->default('Memilih tidak menjawab');
            $table->string('lokasi')->nullable();
            $table->string('spesialisasi')->nullable();
            $table->integer('tarif_jasa')->nullable();
            $table->integer('durasi_pengalaman')->nullable();
            $table->integer('pengalaman_bekerja')->nullable();
            $table->string('pendidikan')->nullable();
            $table->boolean('chat')->default(1);
            $table->boolean('voice_chat')->default(1);
            $table->boolean('video_call')->default(1);
            $table->boolean('status_konsultasi')->default(0);
            $table->string('foto_pengacara')->nullable();
            $table->string('tanda_pengenal')->nullable();
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
