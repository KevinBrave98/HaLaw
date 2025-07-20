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
         Schema::create('riwayat_danas', function (Blueprint $table) {
            $table->id();
            // $table->string('id_riwayat_dana')->primary();
            $table->string('nik_pengacara', 16);
            $table->string('tipe_riwayat_dana');
            $table->string('detail_riwayat_dana');
            // $table->date('tanggal_riwayat_dana');
            // $table->time('waktu_riwayat_dana');
            $table->integer('nominal');
            $table->timestamps();
            
            $table->foreign('nik_pengacara')->references('nik_pengacara')->on('pengacaras')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('riwayat_dana');
    }
};
