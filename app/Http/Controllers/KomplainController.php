<?php

namespace App\Http\Controllers;

use App\Models\Komplain;
use App\Models\Laporan;
use Illuminate\Http\Request;

class KomplainController extends Controller
{
    public function create(Laporan $laporan)
    {
        return view('komplain.create', compact('laporan'));
    }

    public function store(Request $request, Laporan $laporan)
    {
        $data = $request->validate([
            'tipe' => 'required|in:lambat_respon,kurang_jelas,foto_tidak_pantas,kata_kasar,minta_hapus_laporan,lainnya',
            'isi'  => 'required|string|max:1000',
        ]);

        Komplain::create([
            'laporan_id' => $laporan->id,
            'user_id'    => auth()->id(),
            'tipe'       => $data['tipe'],
            'isi'        => $data['isi'],
            'status'     => 'pending',
        ]);

        return redirect()->route('laporan.show', $laporan)
            ->with('success', 'Komplain berhasil dikirim. Admin akan merespon.');
    }

    public function index()
    {
        $komplains = Komplain::where('user_id', auth()->id())
            ->latest()->get();

        return view('komplain.index', compact('komplains'));
    }
}