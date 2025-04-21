<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Api\CutiController;
use App\Http\Controllers\Api\PenggajianApiController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\AbsensiApiController;
use App\Http\Controllers\Api\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    // 🔐 User Info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/profile', [ProfileController::class, 'show']);

    // 🔐 Penggajian
    Route::get('/penggajian', [PenggajianApiController::class, 'index']);
    Route::post('/penggajian', [PenggajianApiController::class, 'store']);
    Route::get('/penggajian/{id}', [PenggajianApiController::class, 'show']);

    // 🔐 Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // 🔐 Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::prefix('absensi')->group(function () {
        Route::get('/', [AbsensiApiController::class, 'index']);
        Route::post('/masuk', [AbsensiApiController::class, 'store']);
        Route::put('/pulang/{id}', [AbsensiApiController::class, 'update']);
        Route::get('/{id}', [AbsensiApiController::class, 'show']);
        Route::post('/sakit', [AbsensiApiController::class, 'absenSakit']); // 👈 Tambahan ini
    });
    
    
    // 🔐 Manajemen Cuti
    Route::prefix('cuti')->group(function () {
        Route::get('/', [CutiController::class, 'index']);
        Route::post('/store', [CutiController::class, 'store']);
        Route::post('{id}/approve', [CutiController::class, 'approve']);
        Route::post('{id}/reject', [CutiController::class, 'reject']);
    });
});
