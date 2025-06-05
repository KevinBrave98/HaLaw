<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

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

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function riwayat(): HasMany
    {
        return $this->hasMany(Riwayat::class, 'nik_pengguna', 'nik_pengguna');
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}