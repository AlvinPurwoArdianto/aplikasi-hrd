<?php

namespace App\Http\Controllers;

use App\Models\Penggajian;
use App\Models\User;
use Illuminate\Http\Request;

class PenggajianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penggajian = Penggajian::latest()->get();
        $pegawai = User::all();
        confirmDelete('Hapus Penggajian!', 'Apakah Anda Yakin?');
        return view('admin.penggajian.index', compact('penggajian', 'pegawai'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $penggajian = Penggajian::all();
        $pegawai = User::all();
        return view('admin.penggajian.index', compact('penggajian', 'pegawai'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        // $request->validate([
        //     'id_pegawai' => 'required|exists:pegawai,id',
        //     'jumlah_gaji' => 'required|numeric',
        //     'bonus' => 'nullable|numeric',
        //     'potongan' => 'nullable|numeric',
        // ]);

        // Simpan data penggajian
        $penggajian = new Penggajian();
        $penggajian->id_user = $request->id_user;
        $penggajian->tanggal_gaji = $request->tanggal_gaji;
        $penggajian->jumlah_gaji = $request->jumlah_gaji;
        $penggajian->bonus = $request->bonus;
        $penggajian->potongan = $request->potongan;
        $penggajian->save();

        // Update total gaji pegawai
        $pegawai = User::find($request->id_user);
        if ($pegawai) {
            $total_gaji = $request->jumlah_gaji + ($request->bonus) - ($request->potongan);
            $pegawai->gaji += $total_gaji;
            $pegawai->save();
        }

        return redirect()->route('penggajian.index')->with('success', 'Penggajian berhasil ditambahkan dan total gaji diperbarui.');
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
    // PenggajianController.php
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $penggajian = Penggajian::findOrFail($id);
        $penggajian->id_user = $request->id_user;
        $penggajian->tanggal_gaji = $request->tanggal_gaji;
        $penggajian->jumlah_gaji = $request->jumlah_gaji;
        $penggajian->bonus = $request->bonus;
        $penggajian->potongan = $request->potongan;
        $penggajian->save();

        // Update total gaji pegawai
        $pegawai = User::find($request->id_user);
        if ($pegawai) {
            $pegawai->gaji = $penggajian->jumlah_gaji + ($request->bonus) - ($request->potongan);
            $pegawai->save();
        }

        return redirect()->route('penggajian.index')->with('success', 'Penggajian berhasil ditambahkan dan total gaji diperbarui.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $penggajian = Penggajian::findOrFail($id);

        $pegawai = User::find($penggajian->id_user);
        if ($pegawai) {
            $pegawai->gaji -= ($penggajian->jumlah_gaji + $penggajian->bonus - $penggajian->potongan);
            $pegawai->save();
        }

        $penggajian->delete();
        return redirect()->route('penggajian.index')->with('danger', 'Penggajian berhasil dihapus dan gaji diperbarui!');
    }

}
