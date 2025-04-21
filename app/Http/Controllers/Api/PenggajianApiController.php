<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Penggajian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenggajianApiController extends Controller
{
    // Get penggajian untuk user yang login
    public function index()
    {
        $user = Auth::user();
        $penggajian = Penggajian::where('id_user', $user->id)->latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Data penggajian berhasil diambil',
            'data' => $penggajian
        ]);
    }

    // Simpan data penggajian (opsional, jika user bisa input sendiri)
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_gaji' => 'required|date',
            'jumlah_gaji' => 'required|numeric',
            'bonus' => 'nullable|numeric',
            'potongan' => 'nullable|numeric',
        ]);

        $user = Auth::user();

        $penggajian = Penggajian::create([
            'id_user' => $user->id,
            'tanggal_gaji' => $request->tanggal_gaji,
            'jumlah_gaji' => $request->jumlah_gaji,
            'bonus' => $request->bonus ?? 0,
            'potongan' => $request->potongan ?? 0,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data penggajian berhasil ditambahkan',
            'data' => $penggajian
        ]);
    }

    // Lihat detail gaji
    public function show($id)
    {
        $user = Auth::user();
        $penggajian = Penggajian::where('id', $id)
                        ->where('id_user', $user->id)
                        ->first();

        if (!$penggajian) {
            return response()->json([
                'status' => false,
                'message' => 'Data penggajian tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail penggajian ditemukan',
            'data' => $penggajian
        ]);
    }
}
