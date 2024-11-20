@extends('layouts.admin.template')
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    {{-- Toast Untuk Error --}}
    @if (session('error'))
        <div class="bs-toast toast toast-placement-ex m-2 bg-danger top-0 end-0 fade show toast-custom" role="alert"
            aria-live="assertive" aria-atomic="true" id="toastError">
            <div class="toast-header">
                <i class="bx bx-error me-2"></i>
                <div class="me-auto fw-semibold">Error</div>
                <small>Just Now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Laporan /</span> Laporan Cuti</h4>
        <div class="card">
            <div class="card-header">
                <form action="{{ route('laporan.cuti') }}" method="GET">
                    <div class="row">
                        <div class="col">
                            <select id="pegawai" name="pegawai" class="form-control">
                                <option value="" disabled {{ request('pegawai') ? '' : 'selected' }}>
                                    -- Pilih Sesuai Nama Pegawai --
                                </option>
                                @foreach ($pegawai as $data)
                                    <option value="{{ $data->id }}"
                                        {{ request('pegawai') == $data->id ? 'selected' : '' }}>
                                        {{ $data->nama_pegawai }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-4">
                            <input type="date" class="form-control" name="tanggal_awal"
                                value="{{ request('tanggal_awal') }}">
                        </div>
                        <div class="col-4">
                            <input type="date" class="form-control" name="tanggal_akhir"
                                value="{{ request('tanggal_akhir') }}">
                        </div>
                        <div class="col-2">
                            <button class="btn btn-primary form-control" type="submit">Filter</button>
                        </div>
                        <div class="col-2">
                            <a href="{{ route('laporan.cuti') }}" class="btn btn-danger form-control">Reset</a>
                        </div>
                    </div>
                </form>
                <div class="row mt-3">
                    <div class="col-6">
                        <select id="pegawai" name="pegawai" class="form-control">
                            <option value="" disabled {{ request('pegawai') ? '' : 'selected' }}>
                                -- Pilih Sesuai Status --
                            </option>
                            <option value="0" {{ request('pegawai') == 'Diterima' ? 'selected' : '' }}>Diterima
                            </option>
                            <option value="1" {{ request('pegawai') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    @if (!$cuti->isEmpty())
                        <div class="col-4">
                            <button id="lihatPdfButtonCuti" class="btn btn-secondary form-control" data-bs-toggle="modal"
                                data-bs-target="#pdfModal">Lihat PDF</button>
                        </div>
                        <div class="col-4">
                            <a href="{{ route('laporan.cuti', ['download_pdf' => true, 'tanggal_awal' => request('tanggal_awal'), 'tanggal_akhir' => request('tanggal_akhir'), 'pegawai' => request('pegawai')]) }}"
                                class="btn btn-info form-control">Buat PDF</a>
                        </div>
                        <div class="col-4">
                            <a href="{{ route('laporan.cuti', ['download_excel' => true, 'tanggal_awal' => request('tanggal_awal'), 'tanggal_akhir' => request('tanggal_akhir'), 'pegawai' => request('pegawai')]) }}"
                                class="btn btn-success form-control">Buat EXCEL</a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if ($cuti->isEmpty())
                    <div class="alert alert-warning" role="alert">
                        Tidak ada data pegawai yang cuti ditemukan untuk tanggal yang dipilih
                    </div>
                @else
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pegawai</th>
                                    <th>Jabatan</th>
                                    <th>Tanggal Mulai Cuti</th>
                                    <th>Tanggal Akhir Cuti</th>
                                    <th>Total Cuti</th>
                                    <th>Status</th>
                                    <th>Alasan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($cuti as $item)
                                    {{-- @dd($item) <!-- Tambahkan ini untuk debugging --> --}}
                                    @if ($item->pegawai->is_admin == 0)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->pegawai->nama_pegawai }}</td>
                                            <td>{{ $item->pegawai->jabatan ? $item->pegawai->jabatan->nama_jabatan : 'Tidak ada jabatan' }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d F Y') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d F Y') }}
                                            </td>
                                            <td>{{ $item->total_hari_cuti }} Hari</td>
                                            <td>
                                                @if ($item->status_cuti === 1)
                                                    <span class="badge bg-label-info">— Diterima —</span>
                                                @else
                                                    <span class="badge bg-label-dark">— Menunggu Konfirmasi —</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->alasan }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal untuk melihat PDF -->
    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Lihat PDF - Cuti</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfFrame" style="width: 100%; height: 500px;" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#pegawai').select2({
                allowClear: true
            });

            document.getElementById('lihatPdfButtonCuti').addEventListener('click', function() {
                var pegawai = '{{ request('pegawai') }}';
                var tanggalAwal = '{{ request('tanggal_awal') }}';
                var tanggalAkhir = '{{ request('tanggal_akhir') }}';

                // Buat URL untuk iframe
                var url = "{{ route('laporan.cuti', ['view_pdf' => true]) }}" +
                    "?pegawai=" + pegawai +
                    "&tanggal_awal=" + tanggalAwal +
                    "&tanggal_akhir=" + tanggalAkhir;

                // Set URL ke iframe
                document.getElementById('pdfFrame').src = url;
            });
        });
    </script>
@endpush
