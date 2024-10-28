<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\CutisController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\RekrutmenController;
use App\Http\Controllers\SocialiteController;
use App\Http\Middleware\isAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => ['auth', isAdmin::class]], function () {
    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Route Jabatan
    // Route::resource('jabatan', JabatanController::class);s
    //Route Jabatan Tanpa Resource
    Route::get('jabatan', [JabatanController::class, 'index'])->name('jabatan.index');
    Route::get('jabatan/create', [JabatanController::class, 'create'])->name('jabatan.create');
    Route::post('jabatan', [JabatanController::class, 'store'])->name('jabatan.store');
    Route::get('jabatan/{id}', [JabatanController::class, 'show'])->name('jabatan.show');
    Route::get('jabatan/{id}/edit', [JabatanController::class, 'edit'])->name('jabatan.edit');
    Route::put('jabatan/{id}', [JabatanController::class, 'update'])->name('jabatan.update');
    Route::delete('jabatan/{id}', [JabatanController::class, 'destroy'])->name('jabatan.destroy');

    // Route pegawai
    // Route::resource('pegawai', PegawaiConteroller::class);
    // Route pegawai Tanpa Resource
    Route::get('pegawai/akun', [PegawaiController::class, 'indexAdmin'])->name('pegawai.admin');
    Route::get('pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
    Route::get('pegawai/{id}', [PegawaiController::class, 'show'])->name('pegawai.show');
    Route::get('pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::put('pegawai/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('pegawai/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');

    //Route Penggajian
    // Route::resource('penggajian', PenggajianController::class);
    // Route Penggajian Tanpa Resource
    Route::get('penggajian', [PenggajianController::class, 'index'])->name('penggajian.index');
    Route::get('penggajian/create', [PenggajianController::class, 'create'])->name('penggajian.create');
    Route::post('penggajian', [PenggajianController::class, 'store'])->name('penggajian.store');
    Route::get('penggajian/{id}', [PenggajianController::class, 'show'])->name('penggajian.show');
    Route::get('penggajian/{id}/edit', [PenggajianController::class, 'edit'])->name('penggajian.edit');
    Route::put('penggajian/{id}', [PenggajianController::class, 'update'])->name('penggajian.update');
    Route::delete('penggajian/{id}', [PenggajianController::class, 'destroy'])->name('penggajian.destroy');

    //Route absensi
    // Route::resource('absensi', AbsensiController::class);
    // Route absensi Tanpa Resource
    Route::get('absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('absensi/create', [AbsensiController::class, 'create'])->name('absensi.create');
    Route::post('absensi', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::get('absensi/{id}', [AbsensiController::class, 'show'])->name('absensi.show');
    Route::get('absensi/{id}/edit', [AbsensiController::class, 'edit'])->name('absensi.edit');
    Route::put('absensi/{id}', [AbsensiController::class, 'update'])->name('absensi.update');
    Route::delete('absensi/{id}', [AbsensiController::class, 'destroy'])->name('absensi.destroy');

    //Route rekrutmen
    // Route::resource('rekrutmen', RekrutmenController::class);
    // Route rekrutmen Tanpa Resource
    Route::get('rekrutmen', [RekrutmenController::class, 'index'])->name('rekrutmen.index');
    Route::get('rekrutmen/create', [RekrutmenController::class, 'create'])->name('rekrutmen.create');
    Route::post('rekrutmen', [RekrutmenController::class, 'store'])->name('rekrutmen.store');
    Route::get('rekrutmen/{id}', [RekrutmenController::class, 'show'])->name('rekrutmen.show');
    Route::get('rekrutmen/{id}/edit', [RekrutmenController::class, 'edit'])->name('rekrutmen.edit');
    Route::put('rekrutmen/{id}', [RekrutmenController::class, 'update'])->name('rekrutmen.update');
    Route::delete('rekrutmen/{id}', [RekrutmenController::class, 'destroy'])->name('rekrutmen.destroy');

    //Route cuti
    // Route::resource('cuti', CutisController::class);
    // Route cuti Tanpa Resource
    Route::get('cuti', [CutisController::class, 'index'])->name('cuti.index');
    Route::get('cuti/create', [CutisController::class, 'create'])->name('cuti.create');
    Route::post('cuti', [CutisController::class, 'store'])->name('cuti.store');
    Route::get('cuti/{id}', [CutisController::class, 'show'])->name('cuti.show');
    Route::get('cuti/{id}/edit', [CutisController::class, 'edit'])->name('cuti.edit');
    Route::put('cuti/{id}', [CutisController::class, 'update'])->name('cuti.update');
    Route::put('/cuti/confirm/{id}', [CutisController::class, 'confirm'])->name('cuti.confirm');
    Route::delete('cuti/{id}', [CutisController::class, 'destroy'])->name('cuti.destroy');

    //Route laporan
    Route::get('laporan/pegawai', [LaporanController::class, 'pegawai'])->name('laporan.pegawai');
    Route::get('laporan/absensi', [LaporanController::class, 'absensi'])->name('laporan.absensi');
    Route::get('laporan/cuti', [LaporanController::class, 'cuti'])->name('laporan.cuti');
});

// LOGIN GOOGLE
// Route::get('auth/google', [LoginController::class, 'redirectToGoogle']);
// Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::get('/redirect', [SocialiteController::class, 'redirect'])->name('redirect')->middleware('guest');
Route::get('/callback', [SocialiteController::class, 'callback'])->name('callback')->middleware('guest');
Route::get('/logout', [SocialiteController::class, 'logout'])->name('socialite.logout')->middleware('auth');
