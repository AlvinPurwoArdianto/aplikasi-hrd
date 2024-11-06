<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PegawaiExport implements FromCollection, WithHeadings
{
    protected $pegawai;

    public function __construct($pegawai)
    {
        $this->pegawai = $pegawai;
    }

    public function collection()
    {
        // Pilih hanya data yang ingin Anda ekspor
        return $this->pegawai->map(function ($item, $key) {
            return [
                'No' => $key + 1,
                'Nama Pegawai' => $item->nama_pegawai,
                'Jabatan' => $item->jabatan->nama ?? 'Tidak Ada Jabatan',
                'Tanggal Masuk' => $item->tanggal_masuk,
                'Umur' => floor(\Carbon\Carbon::parse($item->tanggal_lahir)->diffInYears(\Carbon\Carbon::now())),
                'Email' => $item->email,
                'Gaji' => $item->gaji,
            ];
        });
    }

    public function headings(): array
    {
        return ['No', 'Nama Pegawai', 'Jabatan', 'Tanggal Masuk', 'Umur', 'Email', 'Gaji'];
    }
}
