<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $absensi = Absensi::latest()->get();
        $pegawai = Pegawai::all();
        return view('admin.absensi.index', compact('absensi', 'pegawai'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $absensi = Absensi::all();
        $pegawai = Pegawai::all();
        return view('admin.absensi.index', compact('absensi', 'pegawai'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $request->validate([
            'id_pegawai' => 'required|exists:pegawais,id',
        ]);

        // Ambil waktu sekarang
        $jamMasuk = now()->format('H:i'); // atau bisa gunakan Carbon::now()

        Absensi::create([
            'id_pegawai' => $request->id_pegawai,
            'tanggal_absen' => now()->format('Y-m-d'), // format tanggal
            'jam_masuk' => $jamMasuk, // format jam
        ]);

        return redirect()->route('absensi.index')->with('success', 'Absen Masuk berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $absensi = Absensi::findOrFail($id);
        $pegawai = Pegawai::all();
        return view('admin.absensi.index', compact('absensi', 'pegawai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $absensi = Absensi::find($id);

        if ($absensi && is_null($absensi->jam_keluar)) {
            $absensi->jam_keluar = Carbon::now()->setTimezone('Asia/Jakarta');
            $absensi->save();

            Session::forget('absen_masuk');
            Session::put('absen_keluar', true);
            return redirect()->route('absensi.index')->with('success', 'Absen Pulang berhasil disimpan!');
        }
        return redirect()->route('absensi.index')->with('error', 'Absen Pulang gagal disimpan.');

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
