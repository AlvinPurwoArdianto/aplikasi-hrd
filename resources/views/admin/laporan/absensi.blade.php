@extends('layouts.admin.template')

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Laporan /</span> Laporan Absensi</h4>
        <div class="card">
            <div class="card-header">
                <form action="{{ route('laporan.absensi') }}" method="GET">
                    <div class="row">
                        <div class="col-3">
                            <input type="date" class="form-control" name="tanggal_awal"
                                value="{{ request('tanggal_awal') }}">
                        </div>
                        <div class="col-2">
                            <input type="date" class="form-control" name="tanggal_akhir"
                                value="{{ request('tanggal_akhir') }}">
                        </div>
                        <div class="col-3">
                            <select name="status" class="form-control">
                                <option value="">Pilih Status</option>
                                <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="Pulang" {{ request('status') == 'Pulang' ? 'selected' : '' }}>Pulang</option>
                                <option value="Sakit" {{ request('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                            </select>
                        </div>

                        <div class="col-2">
                            <button class="btn btn-primary form-control" type="submit">Filter</button>
                        </div>
                        <div class="col-2">
                            <a href="{{ route('laporan.absensi') }}" class="btn btn-danger form-control">Reset</a>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <select id="pegawai" name="pegawai_id" class="form-control">
                                <option class="text-center" value="" disabled
                                    {{ request('pegawai_id') ? '' : 'selected' }}>-- Pilih Pegawai --</option>
                                @foreach ($pegawai as $data)
                                    <option value="{{ $data->id }}"
                                        {{ request('pegawai_id') == $data->id ? 'selected' : '' }}>
                                        {{ $data->nama_pegawai }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if (!$absensi->isEmpty())
                            <div class="col-1">
                                <a href="#" id="lihatPdfButtonAbsensi" class="btn btn-secondary form-control"
                                    data-bs-toggle="modal" data-bs-target="#pdfModal">
                                    <i class='bx bx-search-alt-2' data-bs-toggle="tooltip" title="Lihat PDF"></i>
                                </a>
                            </div>
                            <div class="col-1">
                                <button type="submit" name="view_pdf" value="true" class="btn btn-danger"
                                    data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom"
                                    data-bs-html="true" title="Download PDF"> <i class='bx bxs-file-pdf'></i></button>
                            </div>
                            <div class="col-1">
                                <a href="{{ route('laporan.absensi', ['download_excel' => true, 'tanggal_awal' => request('tanggal_awal'), 'tanggal_akhir' => request('tanggal_akhir'), 'pegawai_id' => request('pegawai_id'), 'status' => request('status')]) }}"
                                    class="btn btn-success form-control" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                    data-bs-placement="bottom" data-bs-html="true" title="Download EXCEL">
                                    <i class="bi bi-file-earmark-excel-fill"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
            <div class="card-body">
                @if ($absensi->isEmpty())
                    <div class="alert alert-warning" role="alert">
                        Tidak ada data absensi ditemukan untuk tanggal yang dipilih atau pegawai yang dipilih.
                    </div>
                @else
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered" id="example">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pegawai</th>
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="myTable">
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($absensi as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->user->nama_pegawai }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_absen)->translatedFormat('d F Y') }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->jam_masuk)->translatedFormat('H:i') }}</td>
                                        <td>{{ $item->jam_keluar ? \Carbon\Carbon::parse($item->jam_keluar)->translatedFormat('H:i') : 'Belum Absen Pulang' }}
                                        </td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->note }}</td>
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
                    <h5 class="modal-title" id="pdfModalLabel">Lihat PDF - Absensi</h5>
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
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#pegawai').select2();
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#searchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
    <script>
        document.getElementById('lihatPdfButtonAbsensi').addEventListener('click', function() {
            var pegawai = '{{ request('pegawai_id') }}';
            var tanggalAwal = '{{ request('tanggal_awal') }}';
            var tanggalAkhir = '{{ request('tanggal_akhir') }}';
            var status = '{{ request('status') }}';

            // Encode parameter untuk URL
            var url = "{{ route('laporan.absensi', ['view_pdf' => true]) }}" +
                "?pegawai_id=" + encodeURIComponent(pegawai) +
                "&tanggal_awal=" + encodeURIComponent(tanggalAwal) +
                "&tanggal_akhir=" + encodeURIComponent(tanggalAkhir) +
                "&status=" + encodeURIComponent(status);

            // Set URL ke iframe
            document.getElementById('pdfFrame').src = url;
        });
    </script>
@endpush
