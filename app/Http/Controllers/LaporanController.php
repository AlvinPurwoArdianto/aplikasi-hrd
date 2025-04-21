<?php

namespace App\Http\Controllers;

use App\Exports\AbsensiExport;
use App\Exports\CutiExport;
use App\Exports\PegawaiExport;
use App\Models\Absensi;
use App\Models\Cutis;
use App\Models\Jabatan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{

    public function lihatPDFPegawai(Request $request)
    {
        $jabatanId = $request->query('jabatan');
        $tanggalAwal = $request->query('tanggal_awal');
        $tanggalAkhir = $request->query('tanggal_akhir');
    
        $pegawai = User::where('is_admin', 0)
            ->when($jabatanId, fn($query) => $query->where('id_jabatan', $jabatanId))
            ->when($tanggalAwal && $tanggalAkhir, fn($query) => $query->whereBetween('tanggal_masuk', [$tanggalAwal, $tanggalAkhir]))
            ->get();
    
        $pdf = Pdf::loadView('admin.laporan.pdf_pegawai', compact('pegawai', 'jabatanId', 'tanggalAwal', 'tanggalAkhir'));
        return $pdf->stream('laporan_pegawai.pdf');
    }
    

public function exportExcelPegawai(Request $request)
{
    $jabatanId = $request->query('jabatan');
    $tanggalAwal = $request->query('tanggal_awal');
    $tanggalAkhir = $request->query('tanggal_akhir');

    $pegawai = User::where('is_admin', 0)
        ->when($jabatanId, fn($query) => $query->where('id_jabatan', $jabatanId))
        ->when($tanggalAwal && $tanggalAkhir, fn($query) => $query->whereBetween('tanggal_masuk', [$tanggalAwal, $tanggalAkhir]))
        ->get();

    return Excel::download(new PegawaiExport($pegawai), 'laporan_pegawai.xlsx');
}

    

    public function pegawai(Request $request)
{
    
    
    $responseProvinsi = Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json');
    $provinsi = $responseProvinsi->json();

    $jabatan = Jabatan::all();
    $tanggalAwal = $request->input('tanggal_awal');
    $tanggalAkhir = $request->input('tanggal_akhir');
    $jabatanId = $request->input('jabatan');  // Get the jabatan ID from the request

    $provinsiId = $request->input('provinsi');
    $kabupatenId = $request->input('kabupaten');
    $kecamatanId = $request->input('kecamatan');
    $kelurahanId = $request->input('kelurahan');

    // Apply filters based on the request parameters
    $pegawai = User::where('is_admin', 0)
        ->when($provinsiId, fn ($query) => $query->where('provinsi', $provinsiId))
        ->when($kabupatenId, fn ($query) => $query->where('kabupaten', $kabupatenId))
        ->when($kecamatanId, fn ($query) => $query->where('kecamatan', $kecamatanId))
        ->when($kelurahanId, fn ($query) => $query->where('kelurahan', $kelurahanId))
        ->when($jabatanId, fn ($query) => $query->where('id_jabatan', $jabatanId))  // Filter by jabatanId
        ->when($tanggalAwal && $tanggalAkhir, fn ($query) => $query->whereBetween('tanggal_masuk', [$tanggalAwal, $tanggalAkhir]))
        ->get()
        ->map(function ($pegawai) {
            $pegawai->umur = floor(Carbon::parse($pegawai->tanggal_lahir)->diffInYears(Carbon::now()));
            return $pegawai;
        });

    // If the view_pdf flag is set, generate the PDF
    if ($request->has('view_pdf')) {
        $jabatanId = $request->input('jabatan');
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
    
        // Terapkan filter ke query
        $pegawai = User::where('is_admin', 0)
        ->when($jabatanId, fn($query) => $query->where('id_jabatan', $jabatanId))
        ->when($tanggalAwal && $tanggalAkhir, fn($query) => $query->whereBetween('tanggal_masuk', [$tanggalAwal, $tanggalAkhir]))
        ->get();
    
    Log::info('Filtered Pegawai:', $pegawai->toArray());
    
    
        $pdf = Pdf::loadView('admin.laporan.pdf_pegawai', compact('pegawai', 'jabatanId', 'tanggalAwal', 'tanggalAkhir'));
        return $pdf->stream('laporan_pegawai.pdf');
    }
    
    

    return view('admin.laporan.pegawai', compact('pegawai', 'jabatan', 'provinsi'));
}

    
    
    
public function lihatPDFAbsensi(Request $request)
{
    try {
        $tanggalAwal = $request->query('tanggal_awal');
        $tanggalAkhir = $request->query('tanggal_akhir');
        $pegawaiId = $request->query('pegawai_id');
        $status = $request->query('status');

        // Query data absensi dengan filter
        $absensiQuery = Absensi::query()->with('user');

        if ($tanggalAwal && $tanggalAkhir) {
            $absensiQuery->whereBetween('tanggal_absen', [$tanggalAwal, $tanggalAkhir]);
        }

        if ($pegawaiId) {
            $absensiQuery->where('id_user', $pegawaiId);
        }

        if ($status) {
            $absensiQuery->where('status', $status);
        }

        $absensi = $absensiQuery->latest()->get();

        // Generate PDF dengan data yang difilter
        $pdf = Pdf::loadView('admin.laporan.pdf_absensi', compact('absensi', 'tanggalAwal', 'tanggalAkhir', 'pegawaiId', 'status'));

        return $pdf->stream('laporan_absensi.pdf');
    } catch (\Exception $e) {
        Log::error('Error generating PDF for absensi:', ['message' => $e->getMessage()]);
        return response()->json(['error' => 'Gagal memuat PDF.'], 500);
    }
}

    // LAPORAN BUAT ABSENSI DAN FILTER
    public function absensi(Request $request)
    {
        try {
            // Pastikan model Absensi dapat di-query dengan benar
            $absensiQuery = Absensi::query()->with('user');

            $tanggalAwal = $request->input('tanggal_awal');
            $tanggalAkhir = $request->input('tanggal_akhir');
            $pegawaiId = $request->input('pegawai_id');
            $status = $request->input('status');

            if ($tanggalAwal && $tanggalAkhir) {
                $absensiQuery->whereBetween('tanggal_absen', [$tanggalAwal, $tanggalAkhir]);
            }

            if ($pegawaiId) {
                $absensiQuery->where('id_user', $pegawaiId);
            }

            if ($status) {
                $absensiQuery->where('status', $status);
            }

            $absensi = $absensiQuery->latest()->get();

            $pegawai = User::where('is_admin', 0)->get();

            // Tampilkan PDF
            if ($request->has('view_pdf')) {
                $pdf = Pdf::loadView('admin.laporan.pdf_absensi', compact('absensi'));
                return $pdf->stream('laporan_absensi.pdf');
            }

            // Handle Excel export
            if ($request->has('download_excel')) {
                return Excel::download(new AbsensiExport($pegawaiId, $tanggalAwal, $tanggalAkhir, $status), 'laporan_absensi.xlsx');
            }

            return view('admin.laporan.absensi', compact('absensi', 'pegawai'));
        } catch (\Exception $e) {
            Log::error('Error fetching absensi data:', ['message' => $e->getMessage()]);
            return redirect()->back()->withErrors('Terjadi kesalahan saat mengambil data absensi.');
        }
    }

    public function lihatPDFCuti(Request $request)
{
    // Log untuk debugging
    Log::info('Filter parameters: ', $request->all());

    $pegawaiId = $request->query('pegawai');
    $tanggalAwal = $request->query('tanggal_awal');
    $tanggalAkhir = $request->query('tanggal_akhir');
    $statusCuti = $request->query('status_cuti');

    $cuti = Cutis::with(['pegawai.jabatan'])
        ->when($pegawaiId, fn($query) => $query->where('id_user', $pegawaiId))
        ->when($tanggalAwal && $tanggalAkhir, fn($query) => $query->whereBetween('tanggal_mulai', [$tanggalAwal, $tanggalAkhir]))
        ->when($statusCuti, fn($query) => $query->where('status_cuti', $statusCuti))
        ->get();

    // Log hasil query untuk debugging
    Log::info('Cuti data: ', $cuti->toArray());

    foreach ($cuti as $item) {
        $tanggalMulai = \Carbon\Carbon::parse($item->tanggal_mulai);
        $tanggalAkhir = \Carbon\Carbon::parse($item->tanggal_selesai);
        $item->total_hari_cuti = $tanggalMulai->diffInDays($tanggalAkhir) + 1;
    }

    $pdf = Pdf::loadView('admin.laporan.pdf_cuti', compact('cuti', 'pegawaiId', 'tanggalAwal', 'tanggalAkhir', 'statusCuti'));
    return $pdf->stream('laporan_cuti.pdf');
}


    //LAPORAN BUAT CUTI DAN FILTER
    public function cuti(Request $request)
    {
        $pegawai = User::where('is_admin', 0)->get();
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $pegawaiId = $request->input('pegawai');
        $statusCuti = $request->input('status_cuti');

        $cutiQuery = Cutis::with(['pegawai.jabatan']);

        if ($tanggalAwal && $tanggalAkhir) {
            $cutiQuery->whereBetween('tanggal_mulai', [$tanggalAwal, $tanggalAkhir]);
        }

        if ($pegawaiId) {
            $cutiQuery->where('id_user', $pegawaiId);
        }

        if ($statusCuti) {
            $cutiQuery->where('status_cuti', $statusCuti);
        }

        $cuti = $cutiQuery->get();

        foreach ($cuti as $item) {
            $tanggalMulai = \Carbon\Carbon::parse($item->tanggal_mulai);
            $tanggalAkhir = \Carbon\Carbon::parse($item->tanggal_selesai);
            $item->total_hari_cuti = $tanggalMulai->diffInDays($tanggalAkhir) + 1;
        }

        // Tampilkan PDF
        if ($request->has('view_pdf')) {
            $pdf = PDF::loadView('admin.laporan.pdf_cuti', compact('cuti'));
            return $pdf->stream('laporan_cuti.pdf');
        }

        // Unduh PDF
        if ($request->has('download_pdf')) {
            $pdf = PDF::loadView('admin.laporan.pdf_cuti', compact('cuti'));
            return $pdf->download('laporan_cuti.pdf');
        }

        // Export Excel
        if ($request->has('download_excel')) {
            return Excel::download(new CutiExport($tanggalAwal, $tanggalAkhir, $pegawaiId), 'laporan_cuti.xlsx');
        }

        return view('admin.laporan.cuti', compact('cuti', 'pegawai'));
    }

}
