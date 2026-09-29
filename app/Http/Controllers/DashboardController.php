<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Komplain;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isUser()) {
            $laporans = Laporan::where('user_id', $user->id)
                ->latest()->get();
        } elseif ($user->isStaff()) {
            // ✅ STAFF LIHAT SEMUA LAPORAN PENDING & DIPROSES
            // TIDAK ADA filter moderation_status → langsung muncul!
            $laporans = Laporan::whereIn('status', ['pending', 'diproses'])
                ->latest()->get();
        } else {
            // Admin & Super Admin
            $laporans = Laporan::latest()->get();
        }

        $stats = [
            'total'             => Laporan::count(),
            'pending'           => Laporan::where('status', 'pending')->count(),
            'diproses'          => Laporan::where('status', 'diproses')->count(),
            'selesai'           => Laporan::where('status', 'selesai')->count(),
            'perlu_verifikasi'  => Laporan::where('status', 'pending')
                                            ->where('moderation_status', 'pending')
                                            ->count(),
            'komplain_pending'  => Komplain::where('status', 'pending')->count(),
        ];

        return view('dashboard', compact('laporans', 'stats'));
    }

    public function histori()
    {
        $user = auth()->user();

        if ($user->isUser()) {
            $laporans = Laporan::where('user_id', $user->id)
                ->whereIn('status', ['selesai', 'ditolak'])
                ->latest()->get();
        } elseif ($user->isStaff()) {
            $laporans = Laporan::whereIn('status', ['selesai', 'ditolak'])
                ->latest()->get();
        } else {
            $laporans = Laporan::whereIn('status', ['selesai', 'ditolak'])
                ->latest()->get();
        }

        return view('histori', compact('laporans'));
    }
}