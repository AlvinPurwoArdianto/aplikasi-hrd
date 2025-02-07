@extends('layouts.admin.template')

@section('content')
<div class="container-fluid py-4">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Menu /</span> Izin Sakit</h4>

    <!-- Daftar izin sakit HARI INI -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Izin Sakit Hari Ini</h5>
        </div>
        <div class="card-body">
            @if ($izinSakitHariIni->isEmpty())
                <div class="alert alert-warning" role="alert">
                    Tidak ada pegawai yang izin sakit hari ini.
                </div>
            @else
                <table class="table table-bordered table-hover text-nowrap text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Surat Sakit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($izinSakitHariIni as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->user->nama_pegawai }}</td>
                                <td>{{ \Carbon\Carbon::parse($data->tanggal_absen)->translatedFormat('d F Y') }}</td>
                                <td>
                                    @if ($data->photo)
                                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#photoModal{{ $data->id }}">
                                            <i class='bx bx-show me-1'></i> Lihat Surat Sakit
                                        </button>
                                        <!-- Modal Lihat Selengkapnya -->
                                        <div class="modal fade" id="photoModal{{ $data->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Surat Sakit</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset('uploads/' . $data->photo) }}" alt="Surat Sakit" class="img-fluid rounded">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">Tidak ada surat sakit</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- LAPORAN IZIN SAKIT -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Laporan Izin Sakit</h5>
            <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#laporanIzinSakit" aria-expanded="false">
                <i class='bx bx-list-ul'></i> Lihat Semua
            </button>
        </div>
        <div class="collapse" id="laporanIzinSakit">
            <div class="card-body">
                @if ($allIzinSakit->isEmpty())
                    <div class="alert alert-warning" role="alert">
                        Tidak ada data izin sakit.
                    </div>
                @else
                    <table class="table table-bordered table-hover text-nowrap text-center">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Surat Sakit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allIzinSakit as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->user->nama_pegawai }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->tanggal_absen)->translatedFormat('d F Y') }}</td>
                                    <td>
                                        @if ($data->photo)
                                            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#photoModalAll{{ $data->id }}">
                                                <i class='bx bx-show me-1'></i> Lihat Surat Sakit
                                            </button>
                                            <!-- Modal Lihat Selengkapnya -->
                                            <div class="modal fade" id="photoModalAll{{ $data->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Surat Sakit</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img src="{{ asset('uploads/' . $data->photo) }}" alt="Surat Sakit" class="img-fluid rounded">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">Tidak ada surat sakit</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
