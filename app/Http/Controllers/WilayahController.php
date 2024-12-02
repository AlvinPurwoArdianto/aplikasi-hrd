<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;

class WilayahController extends Controller
{
    public function getKota($provinsiId)
    {
        // Assuming you're using an external API to fetch the data
        $response = Http::get('https://example.com/api/cities/' . $provinsiId);
        return response()->json($response->json());
    }
    
    
    public function getKecamatan($kotaId)
    {
        try {
            $kecamatans = Kecamatan::where('kota_id', $kotaId)->get();
            return response()->json($kecamatans);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch data'], 500);
        }
    }
    
    public function getKelurahan($kecamatanId)
    {
        try {
            $kelurahans = Kelurahan::where('kecamatan_id', $kecamatanId)->get();
            return response()->json($kelurahans);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch data'], 500);
        }
    }
    
}
