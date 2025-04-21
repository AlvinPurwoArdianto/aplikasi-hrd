<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AbsensiApiController extends Controller
{
    public function index()
{
    $userId = auth()->id(); // Ambil ID dari user yang sedang login

    $absensi = Absensi::with('user')
        ->where('id_user', $userId) // Filter hanya data milik user ini
        ->latest()
        ->get();

    return response()->json([
        'success' => true,
        'message' => 'Data absensi berhasil diambil.',
        'data' => $absensi
    ]);
}


    public function absenSakit(Request $request)
{
    $request->validate([
        'id_user' => 'required|exists:users,id',
        'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $file = $request->file('foto');
    $fileName = time() . '_' . $file->getClientOriginalName();
    $file->storeAs('public/surat_sakit', $fileName);

    $absensi = Absensi::create([
        'id_user' => $request->id_user,
        'tanggal_absen' => now()->format('Y-m-d'),
        'jam_masuk' => null,
        'jam_keluar' => null,
        'status' => 'sakit', // ✅ TAMBAHKAN INI
        'catatan' => 'Sakit - Surat: ' . $fileName,
    ]);
    

    return response()->json([
        'success' => true,
        'message' => 'Surat sakit berhasil diunggah.',
        'data' => $absensi
    ]);
}


public function store(Request $request)
{
    $userId = auth()->id(); // Pakai ID dari token

    $sudahAbsen = Absensi::where('id_user', $userId)
        ->whereDate('created_at', today())
        ->first();

    if ($sudahAbsen) {
        return response()->json([
            'success' => false,
            'message' => 'Sudah melakukan absen hari ini.'
        ], 409);
    }

    $absensi = Absensi::create([
        'id_user' => $userId,
        'tanggal_absen' => now()->format('Y-m-d'),
        'jam_masuk' => now()->setTimezone('Asia/Jakarta')->format('H:i'),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Absen masuk berhasil.',
        'data' => $absensi
    ]);
}


    public function update(Request $request, $id)
    {
        $absensi = Absensi::find($id);

        if (!$absensi) {
            return response()->json([
                'success' => false,
                'message' => 'Data absensi tidak ditemukan.'
            ], 404);
        }

        if ($absensi->jam_keluar) {
            return response()->json([
                'success' => false,
                'message' => 'Absen pulang sudah dilakukan.'
            ], 409);
        }

        $absensi->jam_keluar = Carbon::now()->setTimezone('Asia/Jakarta')->format('H:i');
        $absensi->save();

        return response()->json([
            'success' => true,
            'message' => 'Absen pulang berhasil.',
            'data' => $absensi
        ]);
    }

    public function show($id)
    {
        $absensi = Absensi::with('user')->find($id);

        if (!$absensi) {
            return response()->json([
                'success' => false,
                'message' => 'Data absensi tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $absensi
        ]);
    }
}
