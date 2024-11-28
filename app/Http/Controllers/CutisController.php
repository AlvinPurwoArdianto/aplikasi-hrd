<?php

namespace App\Http\Controllers;

use App\Models\Cutis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CutisController extends Controller
{
    public function index()
    {
        $cuti = Cutis::with(['pegawai.jabatan'])->where('id_user', Auth::user()->id)->get();
        confirmDelete('Hapus Cuti!', 'Apakah Anda Yakin?');
        return view('user.cuti.index', compact('cuti'));
    }

    public function menu()
    {
        $cuti = Cutis::latest()->get();
        $cutiNotifications = Cutis::where('status_cuti', 'Menunggu')->get();

        // Hitung total hari cuti untuk setiap record cuti
        foreach ($cuti as $item) {
            $tanggalMulai = \Carbon\Carbon::parse($item->tanggal_mulai);
            $tanggalAkhir = \Carbon\Carbon::parse($item->tanggal_selesai);
            $item->total_hari_cuti = $tanggalMulai->diffInDays($tanggalAkhir) + 1; // +1 agar tanggal mulai juga terhitung
        }

        return view('admin.cuti.menu', compact('cuti', 'cutiNotifications'));
    }

    public function getNotifications()
    {
        // Hitung jumlah cuti dengan status "Menunggu"
        $cutiNotifications = Cutis::where('status_cuti', 'Menunggu')->count();

        // Kembalikan jumlah notifikasi dalam format JSON
        return response()->json([
            'count' => $cutiNotifications,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_cuti' => [
                'required',
                'date',
                'after_or_equal:' . now()->addDays(7)->toDateString(),
            ],
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_cuti',
            'kategori_cuti' => 'required|string|max:255',
            'alasan' => 'required|string|max:255',
        ], [
            'tanggal_cuti.after_or_equal' => 'Anda hanya dapat mengajukan cuti setelah satu minggu kedepan.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai cuti harus setelah atau sama dengan tanggal mulai cuti.',
        ]);

        Cutis::create([
            'id_user' => Auth::id(),
            'tanggal_mulai' => $validated['tanggal_cuti'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'kategori_cuti' => $validated['kategori_cuti'],
            'alasan' => $validated['alasan'],
            'status_cuti' => 'Menunggu',
        ]);

        return redirect()->route('cuti.index')->with('success', 'Pengajuan cuti berhasil diajukan!');
    }
    public function approve($id)
    {
        $cuti = Cutis::findOrFail($id);
        $cuti->status_cuti = 'Diterima';
        $cuti->save();

        return redirect()->back()->with('success', 'Cuti approved successfully.');
    }

    public function reject($id)
    {
        $cuti = Cutis::findOrFail($id);
        $cuti->status_cuti = 'Ditolak';
        $cuti->save();

        return redirect()->back()->with('success', 'Cuti rejected successfully.');
    }
}
