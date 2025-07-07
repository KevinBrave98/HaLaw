<?php

namespace App\Http\Controllers;
use App\Models\Pengacara;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function show()
    {
        $lawyer = Pengacara::where('nik_pengacara', '7900615060870729')->first();
        $total_klien = DB::table('pengacaras')
            ->join('riwayats', 'pengacaras.nik_pengacara', '=', 'riwayats.nik_pengacara')
            ->where('pengacaras.nik_pengacara', $lawyer->nik_pengacara)
            ->count('riwayats.id_riwayat');

        $tarif_jasa = DB::table('pengacaras')
            ->where('nik_pengacara', $lawyer->nik_pengacara)
            ->value('tarif_jasa');

        $biaya_layanan = 10000;
        $total_biaya = $tarif_jasa + $biaya_layanan;
        return view('user.metode_pembayaran', compact('lawyer', 'total_klien', 'total_biaya'));
    }

    public function pilih_payment()
    {
        return view('user.macam_pembayaran');
    }

    public function confirm(Request $request)
    {
        // Validasi data sesuai dengan name="" di form
        $request->validate([
            'card_name' => 'required|string|max:255',
            'card_number' => 'required|string|max:255',
            'expiry_date' => 'required|string|max:10',
            'cvv' => 'required|string|max:5',
            'country' => 'required|string',
            'postal_code' => 'required|string'
        ]);

        // Simpan ke session
        session([
            'payment_data' => $request->only([
                'card_name', 'card_number', 'expiry_date', 'cvv', 'country', 'postal_code'
            ])
        ]);

        // Arahkan ke halaman konfirmasi
        return redirect()->route('payment.show_confirmation');
    }

    public function showConfirmation()
    {
        $data = session('payment_data');

        if (!$data) {
            return redirect()->back()->with('error', 'Data pembayaran tidak ditemukan');
        }

        return view('user.konfirmasi_pembayaran', compact('data'));
    }
}
