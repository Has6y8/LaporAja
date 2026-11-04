<?php

namespace App\Exports;

use App\Models\Laporan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        // Tambahkan 'staff' ke dalam with() agar sistem mengambil data penanggung jawab
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
            'Ditangani Oleh', // Kolom Baru
            'Catatan Petugas',
        ];
    }

    public function map($laporan): array
    {
        // Logika untuk mengambil Nama dan Jabatan Penanggung Jawab
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
            $penanggungJawab, // Data Penanggung Jawab
            $laporan->catatan_staff ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Mendapatkan kolom terakhir secara otomatis (misal: 'I')
        $lastColumn = $sheet->getHighestColumn();
        $lastRow = $sheet->getHighestRow();

        return [
            // Baris pertama (header) diberi warna hijau, teks putih, dan tebal
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '059669'] // Warna hijau LaporAja
                ],
            ],
            // Mengatur format bingkai secara otomatis dari kolom A sampai kolom terakhir
            'A1:' . $lastColumn . $lastRow => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => 'E2E8F0'],
                    ],
                ],
            ],
        ];
    }
}