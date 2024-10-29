@extends('layouts.user.template')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mt-4">
            <!-- Card Selamat Datang -->
            <div class="col-lg-4 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Selamat Datang, {{ Auth::user()->nama_pegawai }}</h6>
                        <ul class="list-unstyled mb-0">
                            <li class="text-sm mb-1">
                                <span class="font-weight-bold">Status:</span> {{ Auth::user()->status_pegawai }}
                            </li>
                            <li class="text-sm mb-1">
                                <span class="font-weight-bold">Jabatan:</span> {{ Auth::user()->jabatan->nama_jabatan ?? 'Tidak ada jabatan' }}
                            </li>
                            <li class="text-sm mb-1">
                                <span class="font-weight-bold">Tanggal Masuk:</span> {{ Auth::user()->tanggal_masuk }}
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-3">
                        <p>Semoga hari Anda menyenangkan! Berikut adalah informasi terbaru tentang Anda dan jadwal kehadiran yang tersedia di kalender.</p>
                    </div>
                </div>
            </div>
            
            <!-- Kalender -->
            <div class="col-lg-8">
                <div class="card overflow-hidden h-100 p-0">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0">Kalender</h5>
                        <div class="dropdown">
                            <button id="prevMonth" class="btn btn-outline-primary btn-sm me-2">← Prev</button>
                            <button id="nextMonth" class="btn btn-outline-primary btn-sm">Next →</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="calendar" class="table-responsive">
                            <!-- Kalender akan dirender di sini oleh JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
