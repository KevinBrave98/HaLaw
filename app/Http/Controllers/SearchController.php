<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pengacara;

class SearchController extends Controller
{
    public function view() {
        $lawyers_search = session('lawyers_search', []);
        return view('hasil_pencarian', compact('lawyers_search'));
    }

    public function search(Request $request)
    {
        $query = $request->nama_pengacara;
        $lawyers = DB::table('pengacaras')->where('status_konsultasi', 1);
        if ($query) {
            $lawyers = $lawyers->where('nama_pengacara', 'LIKE', "$query%");
        }

        if($request->jenis_kelamin) {
            $lawyers = $lawyers
            ->where('jenis_kelamin', $request->jenis_kelamin)
            ->orWhere('jenis_kelamin', 'Memilih tidak menjawab');
        }
        if($request->spesialisasi) {
            $lawyers = $lawyers->where('spesialisasi', 'LIKE', "%$request->spesialisasi%");
        }

        if ($request->jenis_layanan) {
            if(in_array('chat', $request->jenis_layanan)) {
                $lawyers=$lawyers->where('chat', 1);
            }
            if(in_array('voice_chat', $request->jenis_layanan)) {
                $lawyers=$lawyers->where('voice_chat', 1);
            }
            if(in_array('video_call', $request->jenis_layanan)) {
                $lawyers=$lawyers->where('video_call', 1);
            }
        }

        $lawyers = $lawyers->inRandomOrder()->get();
        session(['lawyers_search' => $lawyers]);
        return redirect()->route('search.pengacara.view');
    }
}
