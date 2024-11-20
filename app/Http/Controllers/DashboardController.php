<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function index(){
        $id_user = Auth::id();

        $absensi = Absensi::where('id_user', $id_user)
        ->select('id_user', 'tanggal_absen', 'status')->get();

        return view('user.dashboard.index', compact('absensi'));
    }
}
