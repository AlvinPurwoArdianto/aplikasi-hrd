<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\CutisController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\RekrutmenController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::resource('/', WelcomeController::class)->names('welcome');
// Route::put('/{id}/update', [WelcomeController::class, 'update'])->name('welcome.update');

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

    //Route rekrutmen
    // Route::resource('rekrutmen', RekrutmenController::class);
    // Route rekrutmen Tanpa Resource
    Route::get('rekrutmen', [RekrutmenController::class, 'index'])->name('rekrutmen.index');
    Route::get('rekrutmen/create', [RekrutmenController::class, 'create'])->name('rekrutmen.create');
    Route::post('rekrutmen', [RekrutmenController::class, 'store'])->name('rekrutmen.store');
    Route::get('rekrutmen/{id}', [RekrutmenController::class, 'show'])->name('rekrutmen.show');
    Route::get('rekrutmen/{id}/edit', [RekrutmenController::class, 'edit'])->name('rekrutmen.edit');
    Route::post('rekrutmen/{id}', [RekrutmenController::class, 'update'])->name('rekrutmen.update');
    Route::delete('rekrutmen/{id}', [RekrutmenController::class, 'destroy'])->name('rekrutmen.destroy');

    //Route cuti
    // Route::resource('cuti', CutisController::class);
    // Route cuti Tanpa Resource
    Route::get('cuti', [CutisController::class, 'index'])->name('cuti.index');
    Route::get('cuti/create', [cutisController::class, 'create'])->name('cuti.create');
    Route::post('cuti', [cutisController::class, 'store'])->name('cuti.store');
    Route::get('cuti/{id}', [cutisController::class, 'show'])->name('cuti.show');
    Route::get('cuti/{id}/edit', [cutisController::class, 'edit'])->name('cuti.edit');
    Route::post('cuti/{id}', [cutisController::class, 'update'])->name('cuti.update');
    Route::delete('cuti/{id}', [cutisController::class, 'destroy'])->name('cuti.destroy');
});

// LOGIN GOOGLE
// Route::get('auth/google', [LoginController::class, 'redirectToGoogle']);
// Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::get('/redirect', [SocialiteController::class, 'redirect'])->name('redirect')->middleware('guest');
Route::get('/callback', [SocialiteController::class, 'callback'])->name('callback')->middleware('guest');
Route::get('/logout', [SocialiteController::class, 'logout'])->name('socialite.logout')->middleware('guest');

Auth::routes();

Route::group(['prefix' => 'user', 'middleware' => ['auth']], function () {
    Route::get('dashboard', function () {
        return view('user.dashboard.index');
    });

    Route::get('absensi', [WelcomeController::class, 'index'])->name('welcome.index');
    Route::resource('/absensi', WelcomeController::class)->names('welcome');
    Route::put('/{id}/update', [WelcomeController::class, 'update'])->name('welcome.update');
    Route::get('absensi/create', [WelcomeController::class, 'create'])->name('welcome.create');
    Route::post('absensi', [WelcomeController::class, 'store'])->name('welcome.store');
    Route::get('absensi/{id}/edit', [WelcomeController::class, 'edit'])->name('welcome.edit');
    Route::post('absensi/{id}', [WelcomeController::class, 'update'])->name('welcome.update');

    Route::get('penggajian', [PenggajianController::class, 'index1'])->name('penggajian.index1');
    Route::get('penggajian/create', [PenggajianController::class, 'create1'])->name('penggajian.create1');
    Route::post('penggajian', [PenggajianController::class, 'store1'])->name('penggajian.store1');
    Route::get('penggajian/{id}', [PenggajianController::class, 'show1'])->name('penggajian.show1');
    Route::get('penggajian/{id}/edit', [PenggajianController::class, 'edit1'])->name('penggajian.edit1');
    Route::put('penggajian/{id}', [PenggajianController::class, 'update1'])->name('penggajian.update1');
    Route::delete('penggajian/{id}', [PenggajianController::class, 'destroy1'])->name('penggajian.destroy1');

    Route::get('profile', function () {
        return view('user.profile.index');
    });

});

// Route::get('gsap', function () {
//     return view('gsap');
// });
