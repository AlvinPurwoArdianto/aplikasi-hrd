<?php

namespace App\Http\Controllers;

use App\Models\Cutis;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class CutisController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::all();
        $cuti = Cutis::all();
        return view('admin.cuti.index', compact('cuti', 'pegawai'));
    }

    public function create()
    {
        return view('cuti.create'); // Form untuk membuat cuti
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required|exists:pegawais,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:255',
        ]);
        Cutis::create($request->all()); // Menyimpan data cuti

        return redirect()->route('cuti.index')->with('success', 'Cuti berhasil diajukan.');
    }

    public function edit(Cutis $cuti)
    {
        return view('cuti.edit', compact('cuti'));
    }

    public function update(Request $request, Cutis $cuti)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:255',
        ]);

        $cuti->update($request->all());

        return redirect()->route('cuti.index')->with('success', 'Cuti berhasil diperbarui.');
    }

    public function destroy(Cutis $cuti)
    {
        $cuti->delete();
        return redirect()->route('cuti.index')->with('success', 'Cuti berhasil dihapus.');
    }
}
