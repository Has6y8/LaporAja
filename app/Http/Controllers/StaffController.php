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
            'catatan.required'        => 'Catatan wajib diisi sebagai informasi untuk pelapor.',
        ]);
        
        $update = [
            'status'        => $data['status'],
            'staff_id'      => auth()->id(),
            'catatan_staff' => $data['catatan'],
        ];
        
        if ($request->hasFile('foto_perbaikan')) {
            $image = $request->file('foto_perbaikan');
            $manager = new ImageManager(new Driver());
            $compressedImage = $manager->read($image)->scaleDown(width: 800)->toJpeg(60);
            $update['foto_perbaikan'] = 'data:image/jpeg;base64,' . base64_encode((string) $compressedImage);
        }
        
        $laporan->update($update);
        
        StatusLaporan::create([
            'laporan_id' => $laporan->id,
            'user_id'    => auth()->id(),
            'status'     => $data['status'],
            'keterangan' => $data['catatan'],
        ]);
        
        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }
}