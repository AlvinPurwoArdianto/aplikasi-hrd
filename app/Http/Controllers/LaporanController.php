<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Pegawai;
use App\Models\Penggajian;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $absensi = Absensi::latest()->get();
        $pegawai = Pegawai::all();
        return view('admin.laporan.index', compact('absensi', 'pegawai'));
    }

    public function view_pdf()
    {
        // Inisialisasi mPDF
        $mpdf = new \Mpdf\Mpdf([
            'memory_limit' => '1048M',
            'tempDir' => __DIR__ . '/tmp', // Set temp directory jika diperlukan
            'setAutoTopMargin' => 'stretch', // Agar margin otomatis menyesuaikan gambar besar
            'allow_output_buffering' => true, // Untuk menghindari kesalahan output buffering
        ]);

        $absensi = Absensi::latest()->get();
        $pegawai = Pegawai::all();

        // Render view menjadi string HTML khusus untuk PDF
        $htmlContent = view('team.pdf', compact('teams', 'tims'))->render();

        // Tulis konten HTML ke dalam PDF menggunakan mPDF
        $mpdf->WriteHTML($htmlContent);

        // Output PDF ke browser
        $mpdf->Output();
    }

    public function filter(Request $request)
    {
        $request->validate([
            'jenisLaporan' => 'required',
            'tanggalAwal' => 'required|date',
            'tanggalAkhir' => 'required|date|after_or_equal:tanggalAwal',
        ]);

        $data = [];

        switch ($request->jenisLaporan) {
            case 'pegawai':
                $data = Pegawai::all(); // Ambil semua pegawai
                break;
            case 'absensi':
                $data = Absensi::where('tanggal_absen', '>=', $request->tanggalAwal)
                    ->where('tanggal_absen', '<=', $request->tanggalAkhir)
                    ->get();
                break;
            case 'penggajian':
                $data = Penggajian::where('tanggal_gaji', '>=', $request->tanggalAwal)
                    ->where('tanggal_gaji', '<=', $request->tanggalAkhir)
                    ->get();
                break;
        }

        return view('admin.laporan.show', compact('data', 'request'));
    }
}
