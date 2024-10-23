<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Cutis;
use App\Models\Jabatan;
use App\Models\Pegawai;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $absensi = Absensi::latest()->get();
        $pegawai = Pegawai::all();
        return view('admin.laporan.index', compact('absensi', 'pegawai'));
    }

    // LAPORAN BUAT PEGAWAI DAN FILTER
    public function pegawai(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        if (!$tanggalAwal || !$tanggalAkhir) {
            $pegawai = Pegawai::all();
        } else {
            $pegawai = Pegawai::whereBetween('tanggal_masuk', [$tanggalAwal, $tanggalAkhir])->get();
        }

        if ($pegawai->isEmpty()) {
            if ($request->has('pdf') || $request->has('download_pdf')) {
                return redirect()->back()->with('error', 'PDF ERROR, Tidak ada data yang ditemukan.');
            } //ini buat filter data apakah ada atau tidak
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
        $pegawai = Pegawai::all();
        $jabatan = Jabatan::all();
        $absensi = Absensi::all();
        return view('admin.laporan.absensi', compact('pegawai', 'jabatan', 'absensi'));
    }

    //LAPORAN BUAT CUTI DAN FILTER
    public function cuti()
    {
        $pegawai = Pegawai::all();
        $jabatan = Jabatan::all();
        $cuti = Cutis::all();
        return view('admin.laporan.cuti', compact('pegawai', 'jabatan', 'cuti'));
    }
}
