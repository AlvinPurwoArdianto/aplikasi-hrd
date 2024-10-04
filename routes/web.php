<?php

use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PegawaiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
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
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
