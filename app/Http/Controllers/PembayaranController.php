<?php

namespace App\Http\Controllers;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Riwayat;
use App\Models\Pengacara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{

    public function show($id)
    {
        $lawyer = Pengacara::where('nik_pengacara', $id)->first();

        $total_klien = DB::table('pengacaras')
            ->join('riwayats', 'pengacaras.nik_pengacara', '=', 'riwayats.nik_pengacara')
            ->where('pengacaras.nik_pengacara', $lawyer->nik_pengacara)
            ->count('riwayats.id');

        $tarif_jasa = $lawyer->tarif_jasa;
        $biaya_layanan = 10000;
        $total_biaya = $tarif_jasa + $biaya_layanan;

        // Midtrans Config
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => uniqid(),
                'gross_amount' => $total_biaya,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->nama_pengguna,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->nomor_telepon,
            ],
            'callbacks' => [
                'finish' => url('/konsultasi/sedang-berlangsung')
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('user.metode_pembayaran', compact('lawyer', 'total_klien', 'total_biaya', 'snapToken'));
    }

    public function showConfirmation()
    {
        $data = session('payment_data');

        if (!$data) {
            return redirect()->back()->with('error', 'Data pembayaran tidak ditemukan');
        }

        return view('user.konfirmasi_pembayaran', compact('data'));
    }

    public function storeRiwayat(Request $request)
    {
        $user = Auth::user();

        // Cek dulu apakah sudah ada riwayat untuk user ini dengan pengacara itu
        $cek = DB::table('riwayats')->where([
            ['nik_pengacara', '=', $request->nik_pengacara],
            ['nik_pengguna', '=', $user->nik_pengguna],
            ['status', '=', 'Sedang Berlangsung'],
        ])->first();

        if (!$cek) {
            // $pengacara = Pengacara::where('nik_pengacara', $request->nik_pengacara)->get();
            $riwayat = new Riwayat();
            $riwayat->nik_pengacara = $request->nik_pengacara;
            $riwayat->nik_pengguna = $user->nik_pengguna;
            $riwayat->status = 'Menunggu Konfirmasi';
            // $riwayat->chat = $pengacara->chat;
            // $riwayat->voice_chat = $pengacara->voice_chat;
            // $riwayat->video_call = $pengacara->video_call;

            $riwayat->save();


            // DB::table('riwayats')->insert([
            //     'nik_pengacara' => $request->nik_pengacara,
            //     'nik_pengguna' => $user->nik_pengguna,
            //     'status' => 'menunggu konfirmasi',
            //     'created_at' => now(),
            //     'updated_at' => now()
            // ]);
        }
        return redirect()->route('konsultasi.berlangsung');

        return response()->json(['message' => 'Berhasil disimpan'], 200);
    }
}

// public function pilih_payment()
    // {
    //     return view('user.macam_pembayaran');
    // }

    // public function confirm(Request $request)
    // {
    //     // Validasi data sesuai dengan name="" di form
    //     $request->validate([
    //         'card_name' => 'required|string|max:255',
    //         'card_number' => 'required|string|max:255',
    //         'expiry_date' => 'required|string|max:10',
    //         'cvv' => 'required|string|max:5',
    //         'country' => 'required|string',
    //         'postal_code' => 'required|string'
    //     ]);

    //     // Simpan ke session
    //     session([
    //         'payment_data' => $request->only([
    //             'card_name', 'card_number', 'expiry_date', 'cvv', 'country', 'postal_code'
    //         ])
    //     ]);

    //     // Arahkan ke halaman konfirmasi
    //     return redirect()->route('payment.show_confirmation');
    // }
