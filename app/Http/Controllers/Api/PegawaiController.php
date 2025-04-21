<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = User::where('is_admin', 0)->get();

        return response()->json([
            'status' => true,
            'data' => $pegawai
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'tanggal_masuk' => 'nullable|date',
            'gaji' => 'nullable|numeric',
            'status_pegawai' => 'nullable|boolean',
            'id_jabatan' => 'required|exists:jabatans,id',
        ]);

        $pegawai = User::create([
            'nama_pegawai' => $request->nama_pegawai,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tanggal_masuk' => $request->tanggal_masuk,
            'gaji' => $request->gaji,
            'status_pegawai' => $request->status_pegawai,
            'id_jabatan' => $request->id_jabatan,
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Pegawai berhasil ditambahkan!',
            'data' => $pegawai
        ]);
    }

    public function show($id)
    {
        $pegawai = User::find($id);

        if (!$pegawai) {
            return response()->json(['status' => false, 'message' => 'Pegawai tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $pegawai
        ]);
    }

    public function update(Request $request, $id)
    {
        $pegawai = User::find($id);
        if (!$pegawai) {
            return response()->json(['status' => false, 'message' => 'Pegawai tidak ditemukan'], 404);
        }

        $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
            'alamat' => 'required|string',
            'email' => 'required|email|max:255',
            'tanggal_masuk' => 'nullable|date',
            'gaji' => 'nullable|numeric',
            'status_pegawai' => 'nullable|boolean',
            'id_jabatan' => 'required|exists:jabatans,id',
        ]);

        $pegawai->update($request->only([
            'nama_pegawai', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
            'alamat', 'email', 'tanggal_masuk', 'gaji', 'status_pegawai', 'id_jabatan',
            'provinsi', 'kabupaten', 'kecamatan', 'kelurahan',
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Pegawai berhasil diperbarui!',
            'data' => $pegawai
        ]);
    }

    public function destroy($id)
    {
        $pegawai = User::find($id);

        if (!$pegawai) {
            return response()->json(['status' => false, 'message' => 'Pegawai tidak ditemukan'], 404);
        }

        $pegawai->delete();

        return response()->json([
            'status' => true,
            'message' => 'Pegawai berhasil dihapus'
        ]);
    }
}
