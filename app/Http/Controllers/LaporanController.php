<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\StatusLaporan;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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
            'foto_bukti' => 'required|image|mimes:jpg,jpeg,png|max:5120', // Maksimal upload 5MB
        ]);

        if ($request->hasFile('foto_bukti')) {
            $image = $request->file('foto_bukti');
            
            // 1. Proses Kompresi (Resize maks 800px, kualitas 60%)
            $manager = new ImageManager(new Driver());
            $compressedImage = $manager->read($image)
                ->scaleDown(width: 800) 
                ->toJpeg(60);           

            // 2. Ubah hasil kompresi ke teks Base64
            $imageBase64 = base64_encode((string) $compressedImage);
            
            // 3. Simpan sebagai format Data URI
            $data['foto_bukti'] = 'data:image/jpeg;base64,' . $imageBase64;
        }

        $data['user_id'] = auth()->id();
        $data['status']  = 'pending';

        $laporan = Laporan::create($data);

        StatusLaporan::create([
            'laporan_id' => $laporan->id,
            'user_id'    => auth()->id(),
            'status'     => 'pending',
            'keterangan' => 'Laporan baru dibuat.',
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Laporan berhasil dikirim!');
    }

    public function show(Laporan $laporan)
    {
        if (auth()->user()->isUser() && $laporan->user_id !== auth()->id()) {
            abort(403);
        }
        return view('laporan.show', compact('laporan'));
    }
}