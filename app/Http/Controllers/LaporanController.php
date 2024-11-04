<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Cutis;
use App\Models\Jabatan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LaporanController extends Controller
{
    // public function indexPegawai()
    // {
    //     $absensi = Absensi::latest()->get();
    //     $pegawai = User::all();
    //     return view('admin.laporan.pegawai', compact('absensi', 'pegawai'));
    // }

    // LAPORAN BUAT PEGAWAI DAN FILTER
    public function pegawai(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        if (!$tanggalAwal || !$tanggalAkhir) {
            $pegawai = User::where('is_admin', 0)->get()->map(function ($pegawai) {
                $pegawai->umur = floor(Carbon::parse($pegawai->tanggal_lahir)->diffInYears(Carbon::now()));
                return $pegawai;
            });

        } else {
            $pegawai = User::whereBetween('tanggal_masuk', [$tanggalAwal, $tanggalAkhir])->get();
        }

        // tampil pdf
        if ($request->has('pdf')) {
            $pdf = PDF::loadView('admin.laporan.pdf_pegawai', compact('pegawai'));
            return $pdf->stream('laporan_pegawai.pdf'); //ini buat show pdf
        }
        // download pdf
        if ($request->has('download_pdf')) {
            $pdf = PDF::loadView('admin.laporan.pdf_pegawai', compact('pegawai'));
            return $pdf->download('laporan_pegawai.pdf'); //ini buat download pdf
        }

        return view('admin.laporan.pegawai', compact('pegawai'));
    }

    // LAPORAN BUAT ABSENSI DAN FILTER
    public function absensi()
    {
        $pegawai = User::all();
        $jabatan = Jabatan::all();
        $absensi = Absensi::all();
        return view('admin.laporan.absensi', compact('pegawai', 'jabatan', 'absensi'));
    }

    //LAPORAN BUAT CUTI DAN FILTER
    public function cuti(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        if (!$tanggalAwal || !$tanggalAkhir) {
            $cuti = Cutis::with(['pegawai.jabatan'])->get();
        } else {
            $cuti = Cutis::with(['pegawai.jabatan'])
                ->whereBetween('tanggal_mulai', [$tanggalAwal, $tanggalAkhir])
                ->get();
        }

        // Hitung total hari cuti untuk setiap record cuti
        foreach ($cuti as $item) {
            $tanggalMulai = \Carbon\Carbon::parse($item->tanggal_mulai);
            $tanggalAkhir = \Carbon\Carbon::parse($item->tanggal_selesai);
            $item->total_hari_cuti = $tanggalMulai->diffInDays($tanggalAkhir) + 1; // +1 agar tanggal mulai juga terhitung
        }

        // tampil pdf
        if ($request->has('view_pdf')) {
            $pdf = PDF::loadView('admin.laporan.pdf_cuti', compact('cuti'));
            return $pdf->stream('laporan_cuti.pdf'); // untuk menampilkan PDF
        }

        // download pdf
        if ($request->has('download_pdf')) {
            $pdf = PDF::loadView('admin.laporan.pdf_cuti', compact('cuti'));
            return $pdf->download('laporan_cuti.pdf'); // untuk mendownload PDF
        }

        return view('admin.laporan.cuti', compact('cuti'));
    }
}
