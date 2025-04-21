<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AbsensiExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $pegawaiId, $tanggalAwal, $tanggalAkhir, $status;

    public function __construct($pegawaiId, $tanggalAwal, $tanggalAkhir, $status)
    {
        $this->pegawaiId = $pegawaiId;
        $this->tanggalAwal = $tanggalAwal;
        $this->tanggalAkhir = $tanggalAkhir;
        $this->status = $status;
    }

    public function collection()
    {
        // Membangun query untuk export absensi
        $absensiQuery = Absensi::query()->with('user'); // Eager load relasi user (pegawai)

        if ($this->tanggalAwal && $this->tanggalAkhir) {
            $absensiQuery->whereBetween('tanggal_absen', [$this->tanggalAwal, $this->tanggalAkhir]);
        }

        if ($this->pegawaiId) {
            $absensiQuery->where('id_user', $this->pegawaiId);
        }

        if ($this->status) {
            $absensiQuery->where('status', $this->status);
        }

        return $absensiQuery->get();
    }

    public function map($absensi): array
    {
        return [
            $absensi->user->nama_pegawai, // Nama Pegawai
            $absensi->tanggal_absen, // Tanggal Absen
            $absensi->jam_masuk ? Carbon::parse($absensi->jam_masuk)->format('H:i') : null, // Jam Masuk
            $absensi->jam_keluar ? Carbon::parse($absensi->jam_keluar)->format('H:i') : null, // Jam Keluar
            $absensi->status, // Status (Hadir, Sakit, Izin, Alpa)
            $absensi->note, // Catatan
        ];
    }
    public function headings(): array
    {
        // Menambahkan judul kolom (header) untuk Excel
        return [
            'Nama Pegawai', // Nama Pegawai
            'Tanggal Absen', // Tanggal Absen
            'Jam Masuk', // Jam Masuk
            'Jam Keluar', // Jam Keluar
            'Status', // Status
            'Note', // Catatan
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $rowCount = $this->collection()->count() + 1;

        // Menyesuaikan lebar kolom agar judul dan data tidak terpotong
        $sheet->getColumnDimension('A')->setAutoSize(true); // Nama Pegawai
        $sheet->getColumnDimension('B')->setAutoSize(true); // Tanggal Absen
        $sheet->getColumnDimension('C')->setAutoSize(true); // Jam Masuk
        $sheet->getColumnDimension('D')->setAutoSize(true); // Jam Keluar
        $sheet->getColumnDimension('E')->setAutoSize(true); // Status
        $sheet->getColumnDimension('F')->setAutoSize(true); // Note

        return [
            // Styling untuk header (baris pertama)
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
                'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'CCFFFF']],
            ],
            // Styling untuk border (mengelilingi seluruh data)
            "A1:F{$rowCount}" => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => Color::COLOR_BLACK],
                    ],
                ],
            ],
            // Membuat kolom menjadi otomatis menyesuaikan lebar
            'A:F' => [
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}
