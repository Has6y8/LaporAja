<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\StatusLaporan;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class StaffController extends Controller
{
    public function index()
    {
        $laporans = Laporan::whereIn('status', ['pending', 'diproses'])
            ->latest()->get();

        return view('staff.laporan', compact('laporans'));
    }

    public function updateStatus(Request $request, Laporan $laporan)
    {
        $rules = [
            'status'  => 'required|in:pending,diproses,selesai,ditolak',
            'catatan' => 'required|string|max:1000',
        ];
        
        if ($request->status === 'selesai') {
            $rules['foto_perbaikan'] = 'required|image|mimes:jpg,jpeg,png|max:5120';
        } else {
            $rules['foto_perbaikan'] = 'nullable|image|mimes:jpg,jpeg,png|max:5120';
        }
        
        $data = $request->validate($rules, [
            'foto_perbaikan.required' => 'Foto bukti perbaikan wajib diunggah saat status Selesai.',
            'foto_perbaikan.max'      => 'Ukuran foto maksimal 5MB. Silakan kompres fotonya terlebih dahulu.',
            'catatan.required'        => 'Catatan wajib diisi sebagai informasi untuk pelapor.',
        ]);
        
        $statusLama = $laporan->status;
        $statusBaru = $data['status'];

        $update = [
            'status'        => $statusBaru,
            'staff_id'      => auth()->id(),
            'catatan_staff' => $data['catatan'],
        ];
        
        // 1. Jika status Selesai DAN ada file baru diunggah, kompres & simpan
        if ($statusBaru === 'selesai' && $request->hasFile('foto_perbaikan')) {
            $image = $request->file('foto_perbaikan');
            $manager = new ImageManager(new Driver());
            $compressedImage = $manager->read($image)->scaleDown(width: 800)->toJpeg(60);
            $update['foto_perbaikan'] = 'data:image/jpeg;base64,' . base64_encode((string) $compressedImage);
        } 
        // 2. Jika status BUKAN Selesai (misal diubah kembali ke Proses/Pending), hapus foto lama
        else if ($statusBaru !== 'selesai') {
            $update['foto_perbaikan'] = null;
        }
        
        $laporan->update($update);
        
        // Hanya buat riwayat JIKA statusnya benar-benar berubah (mencegah riwayat dobel)
        if ($statusLama !== $statusBaru) {
            StatusLaporan::create([
                'laporan_id' => $laporan->id,
                'user_id'    => auth()->id(),
                'status'     => $statusBaru,
                'keterangan' => $data['catatan'],
            ]);
        }
        
        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }
}