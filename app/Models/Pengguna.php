<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengguna extends Model
{
    protected $primaryKey = 'nik_pengguna';
    public $incrementing = false;
    protected $fillable = [
        'nik_pengguna',
        'nama_pengguna',
        'email',
        'password',
        'nomor_telepon',
        'jenis_kelamin',
        'foto_pengguna'
    ];

    public function riwayat(): HasMany
    {
        return $this->hasMany(Riwayat::class, 'nik_pengguna', 'nik_pengguna');
    }
}