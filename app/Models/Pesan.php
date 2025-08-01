<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pesan extends Model
{
    // protected $primaryKey = 'id_pesan';
    protected $fillable = [
        'id_riwayat',
        'nik',
        'teks'
    ];

    public function riwayat(): BelongsTo
    {
        return $this->belongsTo(Riwayat::class, 'id_riwayat', 'id');
    }
}
