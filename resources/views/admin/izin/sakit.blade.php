@extends('layouts.admin.template')

@section('content')
    <div class="container-fluid py-4">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Menu /</span> Izin Sakit</h4>

        <!-- Daftar izin sakit -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Data Izin Sakit</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover text-nowrap text-center">
                    @if ($izinSakit->isEmpty())
                        <div class="alert alert-warning" role="alert">
                            Tidak ada data Izin Sakit.
                        </div>
                    @else
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Surat Sakit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($absensi as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->user->nama_pegawai }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->tanggal_absen)->translatedFormat('d F Y') }}</td>
                                    <td class="align-items-center">
                                        <!-- Gambar diperbesar -->
                                        @if ($data->photo)
                                            <!-- Tombol Lihat Selengkapnya di sebelah kanan -->
                                            <button type="button"
                                                class="btn btn-outline-primary btn-sm ms-auto align-items-center"
                                                data-bs-toggle="modal" data-bs-target="#photoModal{{ $data->id }}">
                                                <i class='bx bx-show me-1'></i> Lihat Selengkapnya
                                            </button>
                                            {{-- <div style="flex: 2;">
                                                <img src="{{ asset('uploads/' . $data->photo) }}" alt="Surat Sakit" width="200" class="img-thumbnail">
                                            </div> --}}


                                            <!-- Modal Lihat Selengkapnya -->
                                            <div class="modal fade" id="photoModal{{ $data->id }}" tabindex="-1"
                                                aria-labelledby="photoModalLabel{{ $data->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="photoModalLabel{{ $data->id }}">
                                                                Surat Sakit</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img src="{{ asset('uploads/' . $data->photo) }}"
                                                                alt="Surat Sakit" class="img-fluid rounded">
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
                    @endif
                </table>
            </div>
        </div>
    </div>
@endsection
