<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $absensi = Absensi::where('id_user', Auth::id())
            ->whereDate('tanggal_absen', Carbon::today())
            ->orderBy('jam_masuk', 'desc')
            ->get();

        $pegawai = User::all();

        return view('user.absensi.index', compact('absensi', 'pegawai'));

    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $absensi = Absensi::all();
    //     $pegawai = User::all();
    //     return view('user.absensi.index', compact('absensi', 'pegawai')); //sebelumnya

    // }
    public function create()
    {
        $absensi = Absensi::where('id_user', Auth::id())
            ->whereDate('tanggal_absen', Carbon::today())
            ->orderBy('jam_masuk', 'desc')
            ->get();
        $pegawai = User::all();
        return view('user.absensi.index', compact('pegawai', 'absensi')); //update
    }

    /**
     * Store a newly created resource in storage.
     */

    // public function store(Request $request)
    // {
    //     // Set timezone
    //     date_default_timezone_set('Asia/Jakarta');

    //     // Validate input
    //     $request->validate([
    //         'id_user' => 'required|exists:users,id',
    //     ]);

    //     // Get the current time
    //     $currentTime = Carbon::now('Asia/Jakarta');

    //     // Find the user
    //     $pegawai = User::find($request->id_user);
    //     if (!$pegawai) {
    //         return redirect()->route('welcome.create')->with('error', 'User tidak ditemukan!');
    //     }

    //     // Check if the user has already recorded attendance today
    //     $sudahAbsen = Absensi::where('id_user', $pegawai->id)->whereDate('created_at', Carbon::today('Asia/Jakarta'))->first();
    //     if ($sudahAbsen) {
    //         return redirect()->route('welcome.create')->with('error', 'Anda telah melakukan Absen Hari Ini!');
    //     }

    //     // Check for lateness
    //     $note = null;
    //     $latenessTime = Carbon::createFromTime(8, 0, 0, 'Asia/Jakarta');
    //     if ($currentTime->greaterThan($latenessTime)) {
    //         $note = 'Telat';
    //     }

    //     // Record attendance
    //     Absensi::create([
    //         'id_user' => $request->id_user,
    //         'tanggal_absen' => $currentTime->toDateString(),
    //         'jam_masuk' => $currentTime->toTimeString(),
    //         'note' => $note,
    //     ]);

    //     return redirect()->route('welcome.index')->with('success', 'Absen Masuk berhasil disimpan!');

    // }
    public function store(Request $request)
    {
        // Set timezone
        date_default_timezone_set('Asia/Jakarta');

        // Validate input
        $request->validate([
            'id_user' => 'required|exists:users,id',
        ]);

        // Get the current time
        $currentTime = Carbon::now('Asia/Jakarta');

        // Find the user
        $pegawai = User::find($request->id_user);
        if (!$pegawai) {
            return redirect()->route('welcome.create')->with('error', 'User  tidak ditemukan!');
        }

        // Check if the user has already recorded attendance today
        $sudahAbsen = Absensi::where('id_user', $pegawai->id)->whereDate('created_at', Carbon::today('Asia/Jakarta'))->first();
        if ($sudahAbsen) {
            return redirect()->route('welcome.create')->with('error', 'Anda telah melakukan Absen Hari Ini!');
        }

        // Check for lateness
        $latenessTime = Carbon::createFromTime(8, 0, 0, 'Asia/Jakarta'); // Waktu seharusnya absen

        // Determine lateness note and minutes
        $note = null;
        $telat = 0;

        if ($currentTime->greaterThan($latenessTime)) {
            $note = 'Telat';
            $telat = abs($currentTime->diffInMinutes($latenessTime)); // Menggunakan abs() untuk memastikan nilai positif
        }

        // Record attendance
        Absensi::create([
            'id_user' => $request->id_user,
            'tanggal_absen' => $currentTime->toDateString(),
            'jam_masuk' => $currentTime->toTimeString(),
            'note' => $note,
            'telat' => $telat, // Simpan menit keterlambatan jika perlu
        ]);

        return redirect()->route('welcome.index')->with('success', "Absen berhasil disimpan!");
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
        date_default_timezone_set('Asia/Jakarta'); // Set time zone
        $currentTime = Carbon::now('Asia/Jakarta');
        $today = Carbon::today('Asia/Jakarta')->format('Y-m-d');

        // Retrieve today's attendance record for the given user
        $absensi = Absensi::where('id_user', Auth::user()->id)
            ->where('tanggal_absen', $today)
            ->first();

        if (!$absensi) {
            return redirect()->back()->with('error', 'Data absensi tidak ditemukan untuk hari ini.');
        }

        // Define the check-out time range
        $regularCheckOutEnd = Carbon::createFromTime(15, 0, 0); // Waktu akhir jam kerja reguler
        $lemburStart = Carbon::createFromTime(16, 0, 0); // Waktu mulai lembur

        // Lakukan logika absen pulang
        if (is_null($absensi->jam_keluar)) {
            if ($currentTime->greaterThanOrEqualTo($regularCheckOutEnd)) {
                // Catat absensi pulang
                $absensi->jam_keluar = $currentTime->toTimeString();

                if ($currentTime->greaterThanOrEqualTo($lemburStart)) {
                    // Jika waktu pulang lebih dari jam 16:00, catat lembur
                    $absensi->lembur = 1; // Tandai lembur (1 = ya)
                    $absensi->note = 'Lembur'; // Tambahkan catatan lembur
                } else {
                    // Jika tidak lembur, reset nilai lembur dan catatan
                    $absensi->lembur = 0;
                    $absensi->note = null;
                }

                $absensi->save();
                return redirect()->back()->with('success', 'Absen pulang berhasil disimpan!');
            } else {
                return redirect()->back()->with('error', 'Absen pulang hanya bisa dilakukan setelah jam 16:00.');
            }
        } else {
            return redirect()->back()->with('error', 'Anda sudah melakukan absen pulang hari ini.');
        }
    }


    public function absenSakit(Request $request)
    {
        $id_user = Auth::user()->id;
        $tanggal_absen = \Carbon\Carbon::today('Asia/Jakarta')->format('Y-m-d');

        // Cek apakah sudah ada absen di tanggal ini
        $absensi = Absensi::where('id_user', $id_user)->where('tanggal_absen', $tanggal_absen)->first();

        if ($absensi) {
            return redirect()->back()->with('error', 'Anda sudah absen hari ini');
        }

        $note = 'sakit';

        // Simpan absen sakit
        Absensi::create([
            'id_user' => $id_user,
            'tanggal_absen' => $tanggal_absen,
            'jam_masuk' => null, // No check-in time
            'jam_keluar' => null, // No check-out time
            'status' => 'sakit',
            'note' => $note,
        ]);

        return redirect()->back()->with('success', 'Absen sakit berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
