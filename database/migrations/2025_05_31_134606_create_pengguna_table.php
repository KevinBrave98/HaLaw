<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
         Schema::create('penggunas', function (Blueprint $table) {
            $table->string('nik_pengguna', 16)->primary();
            $table->string('nama_pengguna');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nomor_telepon')->unique();
            $table->string('jenis_kelamin')->default('Memilih tidak menjawab');
            $table->string('foto_pengguna')->nullable();
            $table->string('alamat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('pengguna');
    }
};
