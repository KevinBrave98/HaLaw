<?php

namespace App\Http\Controllers;

use App\Models\Pengacara;
use App\Models\Spesialisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function view()
    {
        $spesialisasi = Spesialisasi::all();
        // For min/max calculations, use the query builder without get()
        $lawyersQuery = Pengacara::where('status_konsultasi', 1);
        $harga_max = $lawyersQuery->max('tarif_jasa');
        $harga_min = $lawyersQuery->min('tarif_jasa');

        if ($harga_max % 1000 != 0) {
            $harga_max += 1000 - ($harga_max % 1000);
        }

        if ($harga_min % 1000 != 0) {
            $harga_min -= $harga_min % 1000;
        }

        $request = request();
        $filters = session('filters', []);
        $lawyers_search = session('lawyers_search', []);

        // If we have lawyers in session, reload them with relationships
        if (!empty($lawyers_search)) {
            $lawyerIds = collect($lawyers_search)->pluck('nik_pengacara');
            $lawyers_search = Pengacara::whereIn('nik_pengacara', $lawyerIds)->with('spesialisasis')->get();
        }

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

        return view('user.hasil_pencarian', compact('lawyers_search', 'filters', 'layananLabels', 'harga_max', 'harga_min', 'spesialisasi'));
    }

    public function search(Request $request)
    {
        $lawyers = Pengacara::where('status_konsultasi', 1);

        // Calculate min/max before applying other filters
        $harga_max = $lawyers->max('tarif_jasa');
        $harga_min = $lawyers->min('tarif_jasa');

        if ($harga_max % 1000 != 0) {
            $harga_max += 1000 - ($harga_max % 1000);
        }

        if ($harga_min % 1000 != 0) {
            $harga_min -= 1000 + ($harga_min % 1000);
        }

        $query = $request->nama_pengacara;

        if ($query) {
            $lawyers = $lawyers->where('nama_pengacara', 'LIKE', "$query%");
        }

        if ($request->jenis_kelamin) {
            $lawyers = $lawyers->where(function ($q) use ($request) {
                $q->where('jenis_kelamin', $request->jenis_kelamin)->orWhere('jenis_kelamin', 'Memilih tidak menjawab');
            });
        }

        if ($request->spesialisasi) {
            $spesialisasi = $request->spesialisasi;
            $lawyers = $lawyers->whereHas('spesialisasis', function ($query) use ($spesialisasi) {
                $query->where('nama_spesialisasi', 'LIKE', "%$spesialisasi%");
            });
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
            $lawyers = $lawyers->where('tarif_jasa', '>=', $min)->where('tarif_jasa', '<=', $max);
        }

        // Ambil hasil dan simpan session - WITH EAGER LOADING
        $lawyers = $lawyers->with('spesialisasis')->inRandomOrder()->get();

        session([
            'lawyers_search' => $lawyers,
            'filters' => [
                'jenis_kelamin' => $request->jenis_kelamin,
                // 'spesialisasi' => $request->spesialisasi,
                'jenis_layanan' => $request->jenis_layanan,
                'min_price' => $min,
                'max_price' => $max,
            ],
        ]);

        return redirect()->route('search.pengacara.view', compact('harga_max', 'harga_min'));
    }
}
