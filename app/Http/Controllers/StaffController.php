<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        // ✅ STAFF LIHAT SEMUA (PENDING + DIPROSES) — tanpa filter moderation
        $laporans = Laporan::whereIn('status', ['pending', 'diproses'])
            ->latest()->get();

        return view('staff.laporan', compact('laporans'));
    }

    public function updateStatus(Request $request, Laporan $laporan)
    {
        return app(AdminController::class)->updateStatus($request, $laporan);
    }
}