<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function view()
    {
        $request = request();
        $filters = session('filters', []);
        $lawyers_search = session('lawyers_search', []);

        $layananLabels = [
            'chat' => 'Pesan',
            'voice_call' => 'Panggilan Suara',
            'video_call' => 'Panggilan Video',
        ];

        if ($request->has('remove_filter')) {
            $key = $request->get('remove_filter');

            if ($key === 'harga') {
                unset($filters['min_price'], $filters['max_price']);
            } elseif ($key === 'jenis_layanan' && $request->has('remove_value')) {
                $value = $request->get('remove_value');
                if (isset($filters['jenis_layanan'])) {
                    $filters['jenis_layanan'] = array_filter($filters['jenis_layanan'], fn($v) => $v !== $value);
                    // Hapus key kalau sudah kosong
                    if (empty($filters['jenis_layanan'])) {
                        unset($filters['jenis_layanan']);
                    }
                }
            } else {
                unset($filters[$key]);
            }

            session(['filters' => $filters]);

            // 🔁 Redirect ke pencarian ulang
            return redirect()->route('search.pengacara.search');
        }

        return view('user.hasil_pencarian', compact('lawyers_search', 'filters', 'layananLabels'));
    }

    public function search(Request $request)
    {
        $query = $request->nama_pengacara;
        $lawyers = DB::table('pengacaras')->where('status_konsultasi', 1);

        if ($query) {
            $lawyers = $lawyers->where('nama_pengacara', 'LIKE', "%$query%");
        }

        if ($request->jenis_kelamin) {
            $lawyers = $lawyers->where('jenis_kelamin', $request->jenis_kelamin)->orWhere('jenis_kelamin', 'Memilih tidak menjawab');
        }
        if ($request->spesialisasi) {
            $lawyers = $lawyers->where('spesialisasi', 'LIKE', "%$request->spesialisasi%");
        }

        if ($request->jenis_layanan) {
            if (in_array('chat', $request->jenis_layanan)) {
                $lawyers = $lawyers->where('chat', 1);
            }
            if (in_array('voice_chat', $request->jenis_layanan)) {
                $lawyers = $lawyers->where('voice_chat', 1);
            }
            if (in_array('video_call', $request->jenis_layanan)) {
                $lawyers = $lawyers->where('video_call', 1);
            }
        }

        // Harga
        $min = $request->input('min_price');
        $max = $request->input('max_price');

        if (!is_null($min) && !is_null($max)) {
            $lawyers = $lawyers->whereBetween('tarif_jasa', [$min, $max]);
        }

        // Ambil hasil dan simpan session
        $lawyers = $lawyers->inRandomOrder()->get();

        session([
            'lawyers_search' => $lawyers,
            'filters' => [
                'jenis_kelamin' => $request->jenis_kelamin,
                'spesialisasi' => $request->spesialisasi,
                'jenis_layanan' => $request->jenis_layanan,
                'min_price' => $min,
                'max_price' => $max,
            ],
        ]);
        return redirect()->route('search.pengacara.view');
    }
}
