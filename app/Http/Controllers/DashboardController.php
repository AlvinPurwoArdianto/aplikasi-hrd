<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'user' => Auth::user()->nama_pegawai,
            'absensi' => [
                'hadir' => 10,
                'pulang' => 8,
                'sakit' => 2,
            ],
            'absensi_per_tahun' => [
                '2023' => 200,
                '2024' => 180,
            ]
        ]);
    }
}
