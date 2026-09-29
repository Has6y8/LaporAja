<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\StatusLaporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function create()
    {
        return view('laporan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'      => 'required|string|max:150',
            'deskripsi'  => 'required|string',
            'lokasi'     => 'required|string|max:150',
            'foto_bukti' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto_bukti')) {
            $data['foto_bukti'] = $request->file('foto_bukti')->store('uploads', 'public');
        }

        $data['user_id']           = auth()->id();
        $data['status']            = 'pending';
        $data['moderation_status'] = 'pending';

        $laporan = Laporan::create($data);

        StatusLaporan::create([
            'laporan_id' => $laporan->id,
            'user_id'    => auth()->id(),
            'status'     => 'pending',
            'keterangan' => 'Laporan baru dibuat, menunggu verifikasi admin.',
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Laporan berhasil dikirim! Menunggu verifikasi admin.');
    }

    public function show(Laporan $laporan)
    {
        if (auth()->user()->isUser() && $laporan->user_id !== auth()->id()) {
            abort(403);
        }
        return view('laporan.show', compact('laporan'));
    }
}