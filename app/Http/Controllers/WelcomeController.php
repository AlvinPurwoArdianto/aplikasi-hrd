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
        $izinSakit = Absensi::where('status', 'sakit')->get();
        $izinSakitCount = $izinSakit->count();

        $pegawai = User::all();

        return view('user.absensi.index', compact('absensi', 'pegawai', 'izinSakit', 'izinSakitCount'));

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $absensi = Absensi::where('id_user', Auth::id())->get();
        $pegawai = User::all();
        return view('user.absensi.index', compact('pegawai', 'absensi')); //update
    }

    /**
     * Store a newly created resource in storage.
     */

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
            return redirect()->route('welcome.create')->with('error', 'User tidak ditemukan!');
        }

        // Check if the user has already recorded attendance today
        $sudahAbsen = Absensi::where('id_user', $pegawai->id)->whereDate('created_at', Carbon::today('Asia/Jakarta'))->first();
        if ($sudahAbsen) {
            return redirect()->route('welcome.create')->with('error', 'Anda telah melakukan Absen Hari Ini!');
        }

        // Check for lateness
        $note = null;
        $latenessTime = Carbon::createFromTime(8, 0, 0, 'Asia/Jakarta');
        if ($currentTime->greaterThan($latenessTime)) {
            $note = 'Telat';
        }

        // Record attendance
        Absensi::create([
            'id_user' => $request->id_user,
            'tanggal_absen' => $currentTime->toDateString(),
            'jam_masuk' => $currentTime->toTimeString(),
            'note' => $note,
        ]);

        return redirect()->route('welcome.index')->with('success', 'Absen Masuk berhasil disimpan!');

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
    //
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

        // Check if it's the correct time to perform check-out
        // if ($currentTime->between(Carbon::createFromTime(15, 0, 0), Carbon::createFromTime(16, 0, 0))) {
        // Update only if `jam_keluar` is not already set
        if (is_null($absensi->jam_keluar)) {
            $absensi->jam_keluar = $currentTime->toTimeString();
            $absensi->save();

            return redirect()->back()->with('success', 'Absen pulang berhasil disimpan!');
        } else {
            return redirect()->back()->with('error', 'Anda sudah melakukan absen pulang hari ini.');
        }
        // } else {
        //     return redirect()->back()->with('error', 'Absen pulang hanya bisa dilakukan antara 15:00 dan 16:00.');
        // }
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

        // Simpan absen sakit
        $absensi = new Absensi();
        $absensi->id_user = $id_user;
        $absensi->tanggal_absen = $tanggal_absen;
        $absensi->status = 'sakit';
        $absensi->note = $request->note;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $absensi->photo = $filename;
        }
        $absensi->save();

        return redirect()->back()->with('success', 'Absen sakit berhasil disimpan');
    }

    public function izinSakit(Request $request)
    {
        // Mengambil data pegawai
        $pegawai = User::all();
    
        // Mengambil data absensi semua
        $allIzinSakit = Absensi::where('status', 'sakit')
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Mengambil data izin sakit hanya untuk hari ini
        $today = Carbon::today('Asia/Jakarta')->toDateString();
        $izinSakitHariIni = Absensi::where('status', 'sakit')
            ->whereDate('tanggal_absen', $today)
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Menghitung jumlah izin sakit hari ini
        $izinSakitCount = $izinSakitHariIni->count();
    
        return view('admin.izin.sakit', compact('izinSakitHariIni', 'izinSakitCount', 'allIzinSakit', 'pegawai'));
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function getIzinSakitHariIni()
    {
        $today = Carbon::today();
        $izinSakitCount = Absensi::where('status', 'sakit')
            ->whereDate('tanggal_absen', $today)
            ->count();
    
        return response()->json(['count' => $izinSakitCount]);
    }
    
    
    // Ketika user membuka halaman izin sakit, reset notifikasi
    public function resetIzinSakitNotif()
    {
        session(['izin_sakit_notif' => 0]); // Reset notifikasi di session
        return response()->json(['success' => true]);
    }
    
    public function destroy($id)
    {
        //
    }
}
