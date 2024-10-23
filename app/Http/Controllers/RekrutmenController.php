<?php

namespace App\Http\Controllers;

use App\Models\Rekrutmen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RekrutmenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rekrutmen = Rekrutmen::latest()->get();
        return view('admin.rekrutmen.index', compact('rekrutmen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rekrutmen.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input form
        $request->validate([
            'nama' => 'required',
            'tanggal_lamaran' => 'required',
            'cv' => 'required|mimes:pdf|max:2048' // Hanya file PDF yang diperbolehkan
        ]);

        // Simpan data rekrutmen
        $rekrutmen = new Rekrutmen();
        $rekrutmen->nama = $request->nama;
        $rekrutmen->tanggal_lamaran = $request->tanggal_lamaran;

        // Simpan file CV ke storage
        if ($request->hasFile('cv')) {
            $filePath = $request->file('cv')->store('cv', 'public');
            $rekrutmen->cv = $filePath;
        }

        $rekrutmen->save();

        return redirect()->route('rekrutmen.index')->with('success', 'Rekrutmen berhasil diajukan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $rekrutmen = Rekrutmen::findOrFail($id);
        return view('admin.rekrutmen.show', compact('rekrutmen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $rekrutmen = Rekrutmen::findOrFail($id);
        return view('admin.rekrutmen.edit', compact('rekrutmen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input form
        $request->validate([
            'nama' => 'required',
            'tanggal_lamaran' => 'required',
            'cv' => 'nullable|mimes:pdf|max:2048' // File CV bisa di-update, tetapi opsional
        ]);

        $rekrutmen = Rekrutmen::findOrFail($id);
        $rekrutmen->nama = $request->nama;
        $rekrutmen->tanggal_lamaran = $request->tanggal_lamaran;

        // Update file CV jika ada perubahan
        if ($request->hasFile('cv')) {
            // Hapus file lama jika ada
            if ($rekrutmen->cv && Storage::disk('public')->exists($rekrutmen->cv)) {
                Storage::disk('public')->delete($rekrutmen->cv);
            }

            // Simpan file baru
            $filePath = $request->file('cv')->store('cv', 'public');
            $rekrutmen->cv = $filePath;
        }

        $rekrutmen->save();

        return redirect()->route('rekrutmen.index')->with('success', 'Rekrutmen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rekrutmen = Rekrutmen::findOrFail($id);

        // Hapus file CV jika ada
        if ($rekrutmen->cv && Storage::disk('public')->exists($rekrutmen->cv)) {
            Storage::disk('public')->delete($rekrutmen->cv);
        }

        $rekrutmen->delete();

        return redirect()->route('rekrutmen.index')->with('success', 'Rekrutmen berhasil dihapus.');
    }

    /**
     * Download CV file.
     */
    /**
 * Download CV file.
 */
public function downloadCV($id)
{
    $rekrutmen = Rekrutmen::findOrFail($id);

    if ($rekrutmen->cv && Storage::disk('public')->exists($rekrutmen->cv)) {
        return response()->download(storage_path('app/public/' . $rekrutmen->cv));
    }

    return redirect()->back()->with('error', 'CV tidak ditemukan.');
}

}
