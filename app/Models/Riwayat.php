<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Riwayat extends Model
{
    use HasFactory;
    // protected $primaryKey = 'id_riwayat';
    protected $fillable = [
        // 'id_riwayat',
        'nik_pengacara',
        'nik_pengguna',
        // 'tanggal',
        // 'waktu',
        'status',
        'chat',
        'voice_chat',
        'video_call',
        'penilaian',
        'ulasan',
        'nominal'
    ];

    public function pesans(): HasMany
    {
        return $this->hasMany(Pesan::class, 'id_riwayat', 'id');
    }

    public function pengacara(): BelongsTo
    {
        return $this->belongsTo(Pengacara::class, 'nik_pengacara', 'nik_pengacara');
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'nik_pengguna', 'nik_pengguna');
    }
}
