<?php

namespace App\Models;

use App\Notifications\resetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengacara extends Authenticatable
{
    use HasFactory, Notifiable;

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
        'chat',
        'voice_chat',
        'video_call',
        'status_konsultasi',
        'total_pendapatan',
        'nama_bank',
        'nomor_rekening',
        'foto_pengacara',
        'tanda_pengenal'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function riwayat(): HasMany
    {
        return $this->hasMany(Riwayat::class, 'nik_pengacara', 'nik_pengacara');
    }

    public function riwayat_dana(): HasMany
    {
        return $this->hasMany(RiwayatDana::class, 'nik_pengacara', 'nik_pengacara');
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sendPasswordResetNotification($token)
    {
        $url = url('/reset-password/pengacara/'.$token).'?email='.urlencode($this->email);;
        $this->notify(new resetPassword($url));
    }

    public function scopeActive(Builder $query): void

    {
        $query->where('status_konsultasi', 1);
    }
}
