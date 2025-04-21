<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();

        // Ambil data provinsi
        $provinsi = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')->collect()
            ->firstWhere('id', (string) $user->provinsi);
        $nama_provinsi = $provinsi['name'] ?? 'Provinsi tidak ditemukan';

        // Ambil data kabupaten
        $kabupaten = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/regencies/{$user->provinsi}.json")->collect()
            ->firstWhere('id', (string) $user->kabupaten);
        $nama_kabupaten = $kabupaten['name'] ?? 'Kabupaten tidak ditemukan';

        // Ambil data kecamatan
        $kecamatan = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/districts/{$user->kabupaten}.json")->collect()
            ->firstWhere('id', (string) $user->kecamatan);
        $nama_kecamatan = $kecamatan['name'] ?? 'Kecamatan tidak ditemukan';

        // Ambil data kelurahan
        $kelurahan = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/villages/{$user->kecamatan}.json")->collect()
            ->firstWhere('id', (string) $user->kelurahan);
        $nama_kelurahan = $kelurahan['name'] ?? 'Kelurahan tidak ditemukan';

        return response()->json([
            'success' => true,
            'message' => 'Profil pengguna berhasil diambil.',
            'data' => [
                'id' => $user->id,
                'nama_pegawai' => $user->nama_pegawai,
                'email' => $user->email,
                'tempat_lahir' => $user->tempat_lahir,
                'tanggal_lahir' => $user->tanggal_lahir,
                'jenis_kelamin' => $user->jenis_kelamin,
                'alamat' => $user->alamat,
                'tanggal_masuk' => $user->tanggal_masuk,
                'gaji' => $user->gaji,
                'status_pegawai' => $user->status_pegawai,
                'provinsi' => $nama_provinsi,
                'kabupaten' => $nama_kabupaten,
                'kecamatan' => $nama_kecamatan,
                'kelurahan' => $nama_kelurahan,
                'jabatan' => $user->jabatan?->nama_jabatan ?? null,
            ]
        ]);
    }
}
