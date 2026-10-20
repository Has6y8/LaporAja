<?php

namespace App\Http\Controllers;

use App\Models\Komplain;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KomplainController extends Controller
{
    public function create(Laporan $laporan)
    {
        return view('komplain.create', compact('laporan'));
    }

    public function store(Request $request, Laporan $laporan)
    {
        $user = auth()->user();

        // Tentukan tipe yang diizinkan berdasarkan role
        if ($user->role === 'user') {
            $allowedTypes = ['pengerjaan_tidak_sesuai', 'lambat_respon', 'lainnya'];
        } elseif ($user->role === 'staff') {
            $allowedTypes = ['kurang_jelas', 'foto_tidak_pantas', 'kata_kasar', 'minta_hapus_laporan', 'lainnya'];
        } else {
            $allowedTypes = ['lainnya'];
        }

        $data = $request->validate([
            'tipe' => ['required', Rule::in($allowedTypes)],
            'isi'  => 'required|string|max:1000',
        ], [
            'tipe.in' => 'Tipe komplain tidak valid untuk role Anda.',
        ]);

        Komplain::create([
            'laporan_id' => $laporan->id,
            'user_id'    => $user->id,
            'tipe'       => $data['tipe'],
            'isi'        => $data['isi'],
            'status'     => 'pending',
        ]);

        return redirect()->route('laporan.show', $laporan->id)
            ->with('success', 'Komplain berhasil dikirim. Admin akan merespon.');
    }

    public function index()
    {
        $komplains = Komplain::where('user_id', auth()->id())
            ->latest()->get();

        // Tandai sudah dibaca
        Komplain::where('user_id', auth()->id())
            ->where('status', 'direspon')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('komplain.index', compact('komplains'));
    }
}