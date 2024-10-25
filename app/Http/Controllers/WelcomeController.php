<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Auth;
class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data absensi dan pegawai setelah reset (jika ada reset)
        $absensi = Absensi::latest()->get();
        $pegawai = Pegawai::all();

        return view('user.absensi.index', compact('absensi', 'pegawai'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $absensi = Absensi::all();
        $pegawai = Pegawai::all();
        return view('user.absensi.index', compact('absensi', 'pegawai'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');

        $pegawai = Pegawai::find($request->id_pegawai);
        $sudahAbsen = Absensi::where('id_Pegawai', $pegawai->id)->whereDate('created_at', today())->first();

        if ($sudahAbsen) {
            return redirect()->route('welcome.create')->with('error', 'Anda telah melakukan Absen Hari Ini!');
        }

        $request->validate([
            'id_pegawai' => 'required|exists:pegawais,id',
        ]);

        $currentTime = Carbon::now('Asia/Jakarta');

// Check if the current time is between 08:00 and 09:00
        if ($currentTime->between(Carbon::createFromTime(8, 0, 0), Carbon::createFromTime(9, 0, 0))) {
            // Proceed to store the check-in data
            Absensi::create([
                'id_pegawai' => Auth::user()->id,
                'tanggal_absen' => $currentTime->toDateString(),
                'jam_masuk' => $currentTime->toTimeString(),
            ]);

            return redirect()->back()->with('success', 'Absen masuk berhasil!');
        } else {
            return redirect()->back()->with('error', 'Absen masuk hanya bisa dilakukan antara 08:00 dan 09:00.');
        }

        // Ambil waktu sekarang
        $jamMasuk = now()->format('H:i'); // atau bisa gunakan Carbon::now()

        Absensi::create([
            'id_pegawai' => $request->id_pegawai,
            'tanggal_absen' => now()->format('Y-m-d'), // format tanggal
            'jam_masuk' => $jamMasuk, // format jam
        ]);

        return redirect()->route('user.absensi.index')->with('success', 'Absen Masuk berhasil disimpan!');
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
        return view('welcome.index', compact('absensi', 'pegawai'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, $id)
    // {
    //     $absensi = Absensi::find($id);

    //     $today = Carbon::today('Asia/Jakarta')->format('Y-m-d');

    //     if ($absensi && $absensi->tanggal_absen == $today && is_null($absensi->jam_keluar)) {
    //         $absensi->jam_keluar = Carbon::now()->setTimezone('Asia/Jakarta');
    //         $absensi->save();

    //         Session::forget('absen_masuk');
    //         Session::put('absen_keluar', true);
    //         return redirect()->route('welcome.index')->with('success', 'Absen Pulang berhasil disimpan!');
    //     }

    //     return redirect()->route('welcome.index')->with('error', 'Absen Pulang gagal disimpan atau sudah dilakukan.');
    // }
    public function update(Request $request, $id)
    {
        $absensi = Absensi::find($id);

        $currentTime = Carbon::now('Asia/Jakarta');


        if ($currentTime->between(Carbon::createFromTime(19, 0, 0), Carbon::createFromTime(20, 0, 0))) {
            $absensi = Absensi::findOrFail($id);
            $absensi->update([
                'jam_keluar' => $currentTime->toTimeString(),
            ]);

            return redirect()->back()->with('success', 'Absen pulang berhasil!');
        } else {
            return redirect()->back()->with('error', 'Absen pulang hanya bisa dilakukan antara 19:00 dan 20:00.');
        }

        if ($absensi && is_null($absensi->jam_keluar)) {
            $absensi->jam_keluar = Carbon::now()->setTimezone('Asia/Jakarta');
            $absensi->save();

            Session::forget('absen_masuk');
            Session::put('absen_keluar', true);
            return redirect()->route('user.absensi.index')->with('success', 'Absen Pulang berhasil disimpan!');
        }
        return redirect()->route('user.absensi.index')->with('error', 'Absen Pulang gagal disimpan.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
