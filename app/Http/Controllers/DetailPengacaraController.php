<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengacara;

class DetailPengacaraController extends Controller
{
    public function show($nik_pengacara)
    {
        $pengacara = Pengacara::where('nik_pengacara', $nik_pengacara)->first();

        if (!$pengacara) {
            abort(404, 'Pengacara tidak ditemukan');
        }

        return view('user.detail_pengacara', compact('pengacara'));
    }
}

