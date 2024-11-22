<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BerkasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawai = User::all();
        $berkas = Berkas::all();
        confirmDelete('Hapus!', 'Apakah anda yakin?');
        return view('admin.berkas.index', compact('berkas', 'pegawai'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required',
            'cv' => 'nullable',
            'kk' => 'nullable',
            'akte' => 'nullable',
            'ktp' => 'nullable',
        ]);

        $berkas = new Berkas();
        $berkas->id_user = $request->id_user;

        // Proses upload file CV
        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            $filePath = $file->store('cv', 'public'); // Menggunakan disk public
            $berkas->file_cv = $filePath;
        }
        // Proses upload file KK
        if ($request->hasFile('kk')) {
            $file = $request->file('kk');
            $filePath = $file->store('kk', 'public'); // Menggunakan disk public
            $berkas->file_kk = $filePath;
        }
        // Proses upload file KTP
        if ($request->hasFile('ktp')) {
            $file = $request->file('ktp');
            $filePath = $file->store('ktp', 'public'); // Menggunakan disk public
            $berkas->file_ktp = $filePath;
        }
        // Proses upload file AKTE
        if ($request->hasFile('akte')) {
            $file = $request->file('akte');
            $filePath = $file->store('akte', 'public'); // Menggunakan disk public
            $berkas->file_akte = $filePath;
        }

        $berkas->save();
        return redirect()->route('berkas.index')->with('success', 'Berkas berhasil disimpan.');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $berkas = Berkas::findOrFail($id);
        if ($berkas->cv && Storage::disk('public')->exists($berkas->cv)) {
            Storage::disk('public')->delete($berkas->cv);
        }
        if ($berkas->kk && Storage::disk('public')->exists($berkas->kk)) {
            Storage::disk('public')->delete($berkas->kk);
        }
        if ($berkas->ktp && Storage::disk('public')->exists($berkas->ktp)) {
            Storage::disk('public')->delete($berkas->ktp);
        }
        if ($berkas->akte && Storage::disk('public')->exists($berkas->akte)) {
            Storage::disk('public')->delete($berkas->akte);
        }
        $berkas->delete();
        return redirect()->route('rekrutmen.index')->with('success', 'Rekrutmen berhasil dihapus.');
    }
}
