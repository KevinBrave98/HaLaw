<?php

namespace App\Http\Controllers;

use App\Models\Pengacara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenarikanController extends Controller
{
    public function dashboard(){
        $pengacara = Auth::guard('lawyer')->user();
        $saldo = $pengacara->total_pendapatan;
        $riwayat_dana_pengacara = $pengacara->riwayat_dana;
        return view('lawyer.penarikan_pendapatan',compact('pengacara','saldo','riwayat_dana_pengacara'));
    }
    public function detail(){
        $pengacara = Auth::guard('lawyer')->user();
        $saldo = $pengacara->total_pendapatan;
        $riwayat_dana_pengacara = $pengacara->riwayat_dana;
        return view('lawyer.detail_penarikan',compact('pengacara','saldo','riwayat_dana_pengacara'));
    }
}
