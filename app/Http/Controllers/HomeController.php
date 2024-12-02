<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absensi;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
{
    $pegawai = User::all();
    $totalPegawai = User::where('is_admin', 0)->count();
    $totalPenggajian = User::sum('gaji');

    // Menghitung absensi berdasarkan status
    $absensiHadir = Absensi::where('status', 'Hadir')->count();
    $absensiPulang = Absensi::where('status', 'Pulang')->count();
    $absensiSakit = Absensi::where('status', 'Sakit')->count();

    return view('home', compact('pegawai', 'totalPegawai', 'totalPenggajian', 'absensiHadir', 'absensiPulang', 'absensiSakit'));
}

}
