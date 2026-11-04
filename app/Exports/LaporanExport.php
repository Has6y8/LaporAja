<?php

namespace App\Exports;

use App\Models\Laporan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings; // Tambahan untuk CSV

class LaporanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithCustomCsvSettings
{
    public function collection()
    {
        return Laporan::with(['user', 'staff'])->latest()->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal Dibuat',
            'Judul Laporan',
            'Pelapor',
            'Lokasi',
            'Deskripsi Kerusakan',
            'Status',
            'Ditangani Oleh',
            'Catatan Petugas',
        ];
    }

    public function map($laporan): array
    {
        $penanggungJawab = '-';
        if ($laporan->staff) {
            $jabatan = $laporan->staff->jabatan ?? $laporan->staff->roleLabel();
            $penanggungJawab = $laporan->staff->name . ' (' . $jabatan . ')';
        }

        return [
            '#'.str_pad($laporan->id, 4, '0', STR_PAD_LEFT),
            $laporan->created_at->format('d M Y - H:i'),
            $laporan->judul,
            $laporan->user->name ?? 'Anonim',
            $laporan->lokasi,
            $laporan->deskripsi,
            strtoupper($laporan->status),
            $penanggungJawab,
            $laporan->catatan_staff ?? '-',
        ];
    }

    // Pengaturan Format CSV
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';', // Pakai titik koma agar langsung rapi di Excel (Regional Indonesia)
            'use_bom' => true,  // Agar karakter khusus (seperti emoji) tidak rusak
        ];
    }
}