<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\User;
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
        $pegawai = User::all();
        return view('admin.absensi.index', compact('absensi', 'pegawai'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $absensi = Absensi::all();
        $pegawai = User::where('is_admin', 0)->get();
        return view('admin.absensi.index', compact('absensi', 'pegawai'));

    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     date_default_timezone_set('Asia/Jakarta');

    //     // Validasi apakah `id_user` ada di dalam tabel `users`
    //     $pegawai = User::find($request->id_user);
    //     if (!$pegawai) {
    //         return redirect()->route('absensi.create')->with('error', 'User tidak ditemukan!');
    //     }

    //     // Cek apakah user telah melakukan absen pada hari ini
    //     $sudahAbsen = Absensi::where('id_user', $pegawai->id)
    //         ->whereDate('tanggal_absen', now()->format('Y-m-d'))
    //         ->exists(); // menggunakan exists untuk efisiensi

    //     if ($sudahAbsen) {
    //         return redirect()->route('absensi.create')->with('error', 'Anda telah melakukan Absen Hari Ini!');
    //     }

    //     // Jika belum absen, ambil waktu sekarang dan simpan data absensi
    //     $jamMasuk = now()->format('H:i'); // menggunakan jam sekarang

    //     Absensi::create([
    //         'id_user' => $pegawai->id,
    //         'tanggal_absen' => now()->format('Y-m-d'), // menyimpan tanggal hari ini
    //         'jam_masuk' => $jamMasuk, // menyimpan waktu masuk
    //     ]);

    //     return redirect()->route('absensi.index')->with('success', 'Absen Masuk berhasil disimpan!');
    // }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        // Ambil pengguna berdasarkan ID dari request
        $pegawai = User::find($request->id_user);
        if (!$pegawai) {
            return redirect()->route('absensi.create')->with('error', 'User tidak ditemukan!');
        }

        // Tambahkan pengecekan jika ID adalah admin, misalnya ID 1
        if ($pegawai->id != 1) {
            // Cek apakah user telah melakukan absen pada hari ini (untuk selain admin)
            $sudahAbsen = Absensi::where('id_user', $pegawai->id)
                ->whereDate('tanggal_absen', now()->format('Y-m-d'))
                ->exists();

            if ($sudahAbsen) {
                return redirect()->route('absensi.create')->with('error', 'Anda telah melakukan Absen Hari Ini!');
            }
        }

        // Jika belum absen atau jika pengguna adalah admin, lakukan absensi
        $jamMasuk = now()->format('H:i'); // menggunakan jam sekarang

        Absensi::create([
            'id_user' => $pegawai->id,
            'tanggal_absen' => now()->format('Y-m-d'), // menyimpan tanggal hari ini
            'jam_masuk' => $jamMasuk, // menyimpan waktu masuk
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
        $pegawai = User::all();
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
