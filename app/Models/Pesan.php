<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesan extends Model
{
    use HasFactory;
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
