<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pesan extends Model
{
    protected $primaryKey = 'id_pesan';
    protected $fillable = [
        'id_pesan',
        'id_riwayat',
        'nik',
        'waktu_pesan',
        'teks'
    ];

    public function pengacara(): BelongsTo
    {
        return $this->belongsTo(Riwayat::class, 'id_riwayat', 'id_riwayat');
    }
}
