<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamus;
use Illuminate\Support\Facades\Auth;


class KamusController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $letter = $request->input('letter');

        $kamus = Kamus::query();

        if ($query) {
            $kamus->where('istilah', 'like', '%' . $query . '%');
        } elseif ($letter) {
            $kamus->where('istilah', 'like', $letter . '%');
        }

        $kamus = $kamus->orderBy('istilah')->paginate(20)->withQueryString();

        // return view('user.kamus_sebelum', compact('kamus', 'query', 'letter'));
        // Cek login atau tidak
        if (Auth::check()) {
            return view('user.kamus_setelah', compact('kamus', 'query', 'letter'));
        } else {
            return view('user.kamus_sebelum', compact('kamus', 'query', 'letter'));
        }
    
    }
}
