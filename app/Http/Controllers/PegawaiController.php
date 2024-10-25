<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawai = User::all();
        $jabatan = Jabatan::all();
        confirmDelete('Hapus Pegawai!', 'Apakah Anda Yakin?');
        return view('admin.pegawai.index', compact('pegawai', 'jabatan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawai = User::all();
        $jabatan = Jabatan::all();
        return view('admin.pegawai.create', compact('pegawai', 'jabatan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pegawai' => 'required|unique:pegawais,nama_pegawai',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'email' => 'required',
            'tanggal_masuk' => 'required',
            'umur' => 'required',
            'status' => 'nullable',
            'id_jabatan' => 'required',
        ], [
            'nama_pegawai.unique' => 'Nama jabatan sudah ada!',
            'tanggal_lahir.required' => 'Tanggal Lahir Harus Diisi!',
            'jenis_kelamin.required' => 'Tanggal Lahir Harus Diisi!',
            'alamat.required' => 'Tanggal Lahir Harus Diisi!',
            'email.required' => 'Tanggal Lahir Harus Diisi!',
            'tanggal_masuk.required' => 'Tanggal Lahir Harus Diisi!',
            'umur.required' => 'Tanggal Lahir Harus Diisi!',
            'id_jabatan.required' => 'Jabatan Harus Diisi!',
        ]
        );

        $pegawai = new User();
        $pegawai->nama_pegawai = $request->nama_pegawai;
        $pegawai->tempat_lahir = $request->tempat_lahir;
        $pegawai->tanggal_lahir = $request->tanggal_lahir;
        $pegawai->jenis_kelamin = $request->jenis_kelamin;
        $pegawai->alamat = $request->alamat;
        $pegawai->email = $request->email;
        $pegawai->password = Hash::make($request->password);
        $pegawai->tanggal_masuk = $request->tanggal_masuk;
        $pegawai->umur = $request->umur;
        $pegawai->gaji = $request->gaji;
        $pegawai->status_pegawai = $request->status_pegawai;
        $pegawai->id_jabatan = $request->id_jabatan;

        $pegawai->save();
        return redirect()->route('pegawai.index')->with('success', 'pegawai berhasil ditambahkan!');

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
        $pegawai = User::findOrFail($id);
        $jabatan = Jabatan::all();
        return view('admin.pegawai.edit', compact('pegawai', 'jabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());

        // $request->validate([
        //     'nama_pegawai' => 'required',
        //     'tempat_lahir' => 'required',
        //     'tanggal_lahir' => 'required',
        //     'jenis_kelamin' => 'required',
        //     'alamat' => 'required',
        //     'email' => 'required',
        //     'tanggal_masuk' => 'required',
        //     'umur' => 'required',
        //     'gaji' => 'required',
        //     // 'status_pegawai' => 'boolean',
        //     'id_jabatan' => 'required',
        // ], [
        //     'nama_pegawai.required' => 'Nama jabatan sudah ada!',
        //     'tempat_lahir.required' => 'Tempat Lahir Harus Diisi!',
        //     'tanggal_lahir.required' => 'Tanggal Lahir Harus Diisi!',
        //     'jenis_kelamin.required' => 'Jenis Kelamin Harus Diisi!',
        //     'alamat.required' => 'Alamat Harus Diisi!',
        //     'email.required' => 'Email Harus Diisi!',
        //     'tanggal_masuk.required' => 'Tanggal Masuk Harus Diisi!',
        //     'umur.required' => 'Umur Harus Diisi!',
        //     'gaji.required' => 'Gaji Harus Diisi!',
        //     'id_jabatan.required' => 'Jabatan Harus Diisi!',
        // ]
        // );

        $pegawai = User::findOrFail($id);
        $pegawai->nama_pegawai = $request->nama_pegawai;
        $pegawai->tempat_lahir = $request->tempat_lahir;
        $pegawai->tanggal_lahir = $request->tanggal_lahir;
        $pegawai->jenis_kelamin = $request->jenis_kelamin;
        $pegawai->alamat = $request->alamat;
        $pegawai->email = $request->email;
        $pegawai->tanggal_masuk = $request->tanggal_masuk;
        $pegawai->umur = $request->umur;
        $pegawai->gaji = $request->gaji;
        $pegawai->status_pegawai = $request->status_pegawai;
        $pegawai->id_jabatan = $request->id_jabatan;

        $pegawai->save();
        return redirect()->route('pegawai.index')->with('warning', 'pegawai berhasil diubah!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pegawai = User::find($id);
        if (Auth::user()->id !== $pegawai->id) {
            $pegawai->delete();
            return redirect()->route('pegawai.index')->with('danger', 'pegawai berhasil dihapus!');
        }

        return redirect()->route('pegawai.index')->with('danger', 'Anda tidak bisa menghapus diri sendiri!');

    }
}
