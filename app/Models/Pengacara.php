<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengacara extends Model
{
    protected $primaryKey = 'nik_pengacara';
    public $incrementing = false;
    protected $fillable = [
        'nik_pengacara',
        'nama_pengacara',
        'email',
        'password',
        'nomor_telepon',
        'jenis_kelamin',
        'lokasi',
        'spesialisasi',
        'tarif_jasa',
        'durasi_pengalaman',
        'pengalaman_bekerja',
        'pendidikan',
        'preferensi_komunikasi',
        'status_konsultasi',
        'foto_pengacara'
    ];

    public function riwayat(): HasMany
    {
        return $this->hasMany(Riwayat::class, 'nik_pengacara', 'nik_pengacara');
    }

    public function riwayat_dana(): HasMany
    {
        return $this->hasMany(RiwayatDana::class, 'nik_pengacara', 'nik_pengacara');
    }
}
