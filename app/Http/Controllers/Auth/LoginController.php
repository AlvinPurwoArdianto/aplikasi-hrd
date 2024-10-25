<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = 'admin/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    // Tambahkan notifikasi setelah login berhasil
    protected function authenticated(Request $request, $user)
    {
        // Menambahkan pesan flash untuk login sukses
        session()->flash('success', 'Login berhasil! Selamat datang, ' . $user->nama_pegawai);
    }
}
