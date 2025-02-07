@extends('layouts.user.template')
<head>
    <!-- Add this inside your <head> tag -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

@section('content')
    <div class="container-fluid py-4">
        <div class="row mt-4">
            <!-- Card Selamat Datang -->
            <div class="col-lg-4 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100 shadow-sm border-0 bg-dark text-light">
                    <div class="card-header pb-0 pt-4 bg-gradient-dark text-white rounded-top">
                        <h4 class="text-capitalize mb-4 text-white">Selamat Datang, {{ Auth::user()->nama_pegawai }}</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-5">
                            <!-- Status -->
                            <li class="text-sm mb-2 d-flex align-items-center text-primary">
                                <i class="fas fa-circle me-2"></i> <!-- Status Icon: Circle -->
                                <span class="font-weight-bold">Status:</span>
                                <span class="ms-1">{{ Auth::user()->status_pegawai == 1 ? 'Aktif' : 'Tidak Aktif' }}</span>
                            </li>
                            <!-- Jabatan -->
                            <li class="text-sm mb-2 d-flex align-items-center text-warning">
                                <i class="fas fa-briefcase me-2"></i> <!-- Jabatan Icon: Briefcase -->
                                <span class="font-weight-bold">Jabatan:</span>
                                <span class="ms-1">{{ Auth::user()->jabatan->nama_jabatan ?? 'Tidak ada jabatan' }}</span>
                            </li>
                            <!-- Tanggal Masuk -->
                            <li class="text-sm d-flex align-items-center text-success">
                                <i class="fas fa-calendar-day me-2"></i> <!-- Tanggal Masuk Icon: Calendar Day -->
                                <span class="font-weight-bold">Tanggal Masuk:</span>
                                <span class="ms-1">{{ Auth::user()->tanggal_masuk }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            

            <!-- Kalender -->
            <div class="col-lg-8">
                <div class="card overflow-hidden h-100 p-0 bg-dark text-light shadow-sm">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0">Kalender</h5>
                        <div class="dropdown">
                            <button id="prevMonth" class="btn btn-outline-light btn-sm me-2">← Prev</button>
                            <button id="nextMonth" class="btn btn-outline-light btn-sm">Next →</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="calendar" class="table-responsive text-light">
                            <!-- Kalender akan dirender di sini oleh JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    /* Sidebar Styling */
    .sidenav {
        background-color: #1e1e2f;
        color: #ffffff;
    }

    .nav-item.active .nav-link {
        background-color: #2a2a3c;
        color: #5e72e4;
        font-weight: bold;
    }

    .nav-item .nav-link {
        position: relative;
        transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
        color: #ffffff;
    }

    .nav-link:hover {
        background-color: #2a2a3c;
        color: #5e72e4;
    }

    .nav-link:hover .icon {
        color: #5e72e4;
    }

    .horizontal.dark {
        border-color: #444;
    }

    /* Calendar Styling */
    .card-header {
        background: linear-gradient(145deg, #333d52, #222b38);
        color: #ffffff;
    }

    .card-header h5 {
        color: #ffffff;
    }

    .table-dark th {
        background-color: #2a2a3c;
        color: #ffffff;
    }

    .table-dark td {
        background-color: #222b38;
        color: #ffffff;
    }

    .bg-primary {
        background-color: #3c4d6f !important;
    }

    .bg-dark {
        background-color: #222b38 !important;
    }

    .text-light {
        color: #e0e0e0 !important;
    }

    .table-responsive {
        background-color: #222b38;
        padding: 20px;
    }
</style>
