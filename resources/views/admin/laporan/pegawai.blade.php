@extends('layouts.admin.template')

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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Laporan /</span> Laporan Pegawai</h4>
        <div class="card">
            <div class="card-header">
                <form action="{{ route('laporan.pegawai') }}" method="GET">
                    @csrf
                    <div class="row">
                        <div class="col-4">
                            <input type="date" class="form-control" name="tanggal_awal" required>
                        </div>
                        <div class="col-4">
                            <input type="date" class="form-control" name="tanggal_akhir" required>
                        </div>
                        <div class="col-4">
                            <button class="btn btn-primary form-control" type="submit">Filter</button>
                        </div>
                    </div>
                </form>
                <div class="row mt-3">
                    <div class="col-4">
                        <button id="lihatPdfButton" class="btn btn-secondary form-control" data-bs-toggle="modal"
                            data-bs-target="#pdfModal">Lihat PDF</button>
                    </div>
                    <div class="col-4">
                        <a href="{{ route('laporan.pegawai', ['download_pdf' => true, 'tanggal_awal' => request('tanggal_awal'), 'tanggal_akhir' => request('tanggal_akhir')]) }}"
                            class="btn btn-danger form-control">Buat PDF</a>
                    </div>
                    <div class="col-4">
                        <button class="btn btn-success form-control" type="submit">Buat EXCEL</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if ($pegawai->isEmpty())
                    <div class="alert alert-warning" role="alert">
                        Tidak ada data pegawai ditemukan untuk tanggal yang dipilih.
                    </div>
                @else
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pegawai</th>
                                    <th>Jabatan</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Umur</th>
                                    <th>Email</th>
                                    <th>Gaji</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pegawai as $item)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $item->nama_pegawai }}</td>
                                        <td>{{ $item->jabatan->nama_jabatan }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_masuk)->translatedFormat('d F Y') }}
                                        </td>
                                        <td>{{ $item->umur }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->gaji }}</td>
                                    </tr>
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
                    <h5 class="modal-title" id="pdfModalLabel">Lihat PDF - Pegawai</h5>
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
    <script>
        document.getElementById('lihatPdfButton').addEventListener('click', function() {
            // Ambil tanggal awal dan tanggal akhir dari request
            var tanggalAwal = '{{ request('tanggal_awal') }}';
            var tanggalAkhir = '{{ request('tanggal_akhir') }}';

            // Buat URL untuk iframe
            var url = "{{ route('laporan.pegawai', ['view_pdf' => true]) }}&tanggal_awal=" + tanggalAwal +
                "&tanggal_akhir=" + tanggalAkhir;

            // Set URL ke iframe
            document.getElementById('pdfFrame').src = url;
        });
    </script>
@endpush
