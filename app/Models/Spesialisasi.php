<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Spesialisasi extends Model
{
    // protected $primaryKey = 'id_pesan';
    protected $fillable = [
        'name',
    ];

    public function pengacara_spesialisasi(): BelongsToMany
    {
        return $this->belongsToMany(Pengacara::class, 'pengacara_spesialisasi', 'id', 'nik_pengacara');
    }
}
