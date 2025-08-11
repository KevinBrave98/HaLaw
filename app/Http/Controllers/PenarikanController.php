<?php

namespace App\Http\Controllers;

use App\Models\Pengacara;
use App\Models\RiwayatDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenarikanController extends Controller
{
    public function dashboard()
    {
        $pengacara = Auth::guard('lawyer')->user();
        $saldo = $pengacara->total_pendapatan;
        $riwayat_dana_pengacara = $pengacara->riwayat_dana;
        $bank = $pengacara->nama_bank;
        $nomor_rekening = $pengacara->nomor_rekening;
        $riwayat_tarik = $pengacara->riwayat_danas()->orderBy('created_at', 'desc')->get();
        return view('lawyer.penarikan_pendapatan', compact('pengacara', 'saldo', 'riwayat_dana_pengacara', 'bank', 'nomor_rekening', 'riwayat_tarik'));
    }
    public function detail()
    {
        $pengacara = Auth::guard('lawyer')->user();
        $saldo = $pengacara->total_pendapatan;
        $bank = $pengacara->nama_bank;
        $nomor_rekening = $pengacara->nomor_rekening;
        $riwayat_dana_pengacara = $pengacara->riwayat_dana;
        return view('lawyer.detail_penarikan', compact('pengacara', 'saldo', 'riwayat_dana_pengacara', 'bank', 'nomor_rekening'));
    }

    public function viewUpdate()
    {
        $pengacara = Auth::guard('lawyer')->user();
        return view('lawyer.ubah_rekening', compact('pengacara'));
    }
    public function updateRekening(Request $request)
    {
        $request->validate([
            'nama_bank' => 'required|string',
            'nomor_rekening' => 'required|numeric',
        ]);

        $pengacara = Auth::guard('lawyer')->user();

        $pengacara->nama_bank = $request->nama_bank;
        $pengacara->nomor_rekening = $request->nomor_rekening;
        $pengacara->save();

        return redirect()->route('lawyer.penarikan.pendapatan');
    }

    public function tarikDana(Request $request)
    {
        $request->validate([
            'jumlah_penarikan' => 'required|numeric|min:1',
        ]);

        $pengacara = Auth::guard('lawyer')->user();
        $biaya = 1000;
        $total_penarikan = $request->jumlah_penarikan;
        session([
            'total_penarikan' => $total_penarikan,
        ]);

        if ($pengacara->total_pendapatan < $total_penarikan + $biaya) {
            return redirect()->route('lawyer.penarikan_gagal');
        }
        // tolong masukkan kedalam tabel riwayat_dana
        $riwayat = new RiwayatDana();
        $riwayat->nik_pengacara = $pengacara->nik_pengacara;
        $riwayat->tipe_riwayat_dana = 'Tarik Dana';
        $riwayat->detail_riwayat_dana = $pengacara->nomor_rekening;
        $riwayat->nominal = $total_penarikan;
        $riwayat->save();
        // Kurangi saldo pengacara
        $pengacara->total_pendapatan -= $total_penarikan + $biaya;
        $pengacara->save();

        return redirect()->route('lawyer.hasil.penarikan');
    }

    public function hasilpenarikan()
    {
        $total_penarikan = session('total_penarikan');
        return view('lawyer.hasil_penarikan', compact('total_penarikan'));
    }
    public function gagal()
    {
        $total_penarikan = session('total_penarikan');
        return view('lawyer.penarikan_gagal', compact('total_penarikan'));
    }
}
