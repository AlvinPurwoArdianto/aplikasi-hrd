<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cutis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CutiController extends Controller
{
    public function index()
    {
        $cuti = Cutis::where('id_user', Auth::id())->get();

        $cuti->transform(function ($item) {
            $item->durasi_hari = Carbon::parse($item->tanggal_mulai)
                ->diffInDays(Carbon::parse($item->tanggal_selesai)) + 1;
            $item->tanggal_mulai_format = Carbon::parse($item->tanggal_mulai)->translatedFormat('d F Y');
            $item->tanggal_selesai_format = Carbon::parse($item->tanggal_selesai)->translatedFormat('d F Y');
            return $item;
        });

        return response()->json([
            'message' => 'Data cuti ditemukan',
            'cuti' => $cuti
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:' . now()->addDays(7)->toDateString(),
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'kategori_cuti' => 'required|string|max:255',
            'alasan' => 'required|string|max:255',
        ]);

        $cuti = Cutis::create([
            'id_user' => Auth::id(),
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'kategori_cuti' => $validated['kategori_cuti'],
            'alasan' => $validated['alasan'],
            'status_cuti' => 'Menunggu',
        ]);

        return response()->json([
            'message' => 'Cuti berhasil diajukan',
            'cuti' => $cuti
        ], 201);
    }

    public function approve($id)
    {
        $cuti = Cutis::findOrFail($id);
        $cuti->status_cuti = 'Diterima';
        $cuti->save();

        return response()->json(['message' => 'Cuti disetujui'], 200);
    }

    public function reject($id)
    {
        $cuti = Cutis::findOrFail($id);
        $cuti->status_cuti = 'Ditolak';
        $cuti->save();

        return response()->json(['message' => 'Cuti ditolak'], 200);
    }
}
