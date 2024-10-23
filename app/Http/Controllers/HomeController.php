<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Penggajian;


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
  // HomeController.php
  public function index()
  {
      $pegawai = Pegawai::all();
  
      $totalPegawai = Pegawai::count('id');
      $totalPenggajian = Penggajian::sum('jumlah_gaji');
  
      // Get current month
      $currentMonth = date('m');
      $currentYear = date('Y');
  
      // Get total salary for the current month
      $totalPenggajianBulanIni = Penggajian::whereMonth('tanggal_gaji', $currentMonth)
                                             ->whereYear('tanggal_gaji', $currentYear)
                                             ->sum('jumlah_gaji');
  
      return view('home', compact('pegawai', 'totalPegawai', 'totalPenggajian', 'totalPenggajianBulanIni'));
  }
  

}
    