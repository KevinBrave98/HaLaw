<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatDana extends Model
{
    protected $primaryKey = 'id_riwayat_dana';
    protected $fillable = [
        'id_riwayat_dana',
        'nik_pengacara',
        'tipe_riwayat_dana',
        'detail_riwayat_dana',
        'tanggal_riwayat_dana',
        'waktu_riwayat_dana',
        'nominal',
    ];

    public function pengacara(): BelongsTo
    {
        return $this->belongsTo(Pengacara::class, 'nik_pengacara', 'nik_pengacara');
    }

    protected static function booted()
    {
        static::created(function ($riwayatDana) {
            $riwayatDana->updateTotalPendapatan();
        });

        static::updated(function ($riwayatDana) {
            $riwayatDana->updateTotalPendapatan();
        });

        static::deleted(function ($riwayatDana) {
            $riwayatDana->updateTotalPendapatan();
        });
    }

    public function updateTotalPendapatan()
    {
        $pengacara = \App\Models\Pengacara::where('nik_pengacara', $this->nik_pengacara)->first();

        if ($pengacara) {
            $total = $pengacara->riwayat_danas()->sum('nominal');
            $pengacara->update(['total_pendapatan' => $total]);
            $pengacara->save();
        }
    }
}
