<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\RekrutmenController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
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
    Route::get('pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('pegawai/create', [pegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('pegawai', [pegawaiController::class, 'store'])->name('pegawai.store');
    Route::get('pegawai/{id}', [pegawaiController::class, 'show'])->name('pegawai.show');
    Route::get('pegawai/{id}/edit', [pegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::put('pegawai/{id}', [pegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('pegawai/{id}', [pegawaiController::class, 'destroy'])->name('pegawai.destroy');

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
    Route::post('absensi/{id}', [AbsensiController::class, 'update'])->name('absensi.update');
    Route::delete('absensi/{id}', [AbsensiController::class, 'destroy'])->name('absensi.destroy');

    // Route::post('absen-pulang/{id}', [AbsensiController::class, 'absenPulang'])->name('absen.pulang');
    Route::get('rekrutmen', [RekrutmenController::class, 'index'])->name('rekrutmen.index');

});

// LOGIN GOOGLE
Route::get('auth/google', [LoginController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

Auth::routes();
