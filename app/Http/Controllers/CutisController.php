<?php

namespace App\Http\Controllers;

use App\Models\Cutis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CutisController extends Controller
{
    public function index()
    {
        $pegawai = User::all();
        $cuti = Cutis::with(['pegawai.jabatan'])->get();
        confirmDelete('Hapus Cuti!', 'Apakah Anda Yakin?');
        return view('admin.cuti.index', compact('cuti', 'pegawai'));
    }
    public function index1()
    {
        $pegawai = User::all();
        $cuti = Cutis::with(['pegawai.jabatan'])->get();
        confirmDelete('Hapus Cuti!', 'Apakah Anda Yakin?');
        return view('user.cuti.index', compact('cuti', 'pegawai'));
    }

    public function create()
    {
        return view('cuti.create'); // Form untuk membuat cuti
    }

    public function store1(Request $request)
    {
        $request->validate([
            'tanggal_cuti' => 'required|date',
            'alasan' => 'required|string|max:255',
        ]);

        Cutis::create([
            'user_id' => Auth::user()->id,
            'tanggal_cuti' => $request->tanggal_cuti,
            'alasan' => $request->alasan,
            'status' => 'Pending', // atau sesuai logika aplikasi
        ]);

        return redirect()->back()->with('success', 'Pengajuan cuti berhasil dikirim.');
    }

    public function updateStatus(Request $request, $id)
    {
        $cuti = Cutis::findOrFail($id);
        $cuti->status = $request->status;
        $cuti->save();

        return redirect()->back()->with('success', 'Status cuti berhasil diperbarui.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:255',
        ]);
        // Simpan data cuti baru
        $cuti = new Cutis();
        $cuti->id_user = $request->id_user;
        $cuti->tanggal_mulai = $request->tanggal_mulai;
        $cuti->tanggal_selesai = $request->tanggal_selesai;
        $cuti->alasan = $request->alasan;
        $cuti->save();

        return redirect()->route('cuti.index')->with('success', 'Cuti berhasil diajukan.');
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $cuti = Cutis::findOrFail($id);
        $cuti->delete();
        return redirect()->route('cuti.index')->with('success', 'Cuti berhasil dihapus.');
    }
}
