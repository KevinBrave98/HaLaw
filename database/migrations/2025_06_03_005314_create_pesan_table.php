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
        Schema::create('pesans', function (Blueprint $table) {
            $table->id();
            $table->string('id_riwayat');
            $table->string('nik', 16);
            // $table->dateTime('waktu_pesan');
            $table->text('teks');
            $table->timestamps();

            $table->foreign('id_riwayat')->references('id_riwayat')->on('riwayats')->cascadeOnDelete();
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
