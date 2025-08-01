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
        Schema::create('pengacara_spesialisasi', function (Blueprint $table) {
            $table->unsignedBigInteger('id_spesialisasi');
            $table->string('nik_pengacara', 16);

            $table->foreign('id_spesialisasi')->references('id')->on('spesialisasis');
            $table->foreign('nik_pengacara')->references('nik_pengacara')->on('pengacaras');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengacara_spesialisasi');
    }
};
