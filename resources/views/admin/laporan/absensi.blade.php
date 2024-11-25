@extends('layouts.admin.template')
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Laporan /</span> Laporan Absensi</h4>
        <div class="card">
            <div class="card-header">
                <form method="GET" action="{{ route('laporan.absensi') }}">
                    <div class="row">
                        <!-- Filter Inputs -->
                        <div class="col-3">
                            <input type="date" class="form-control" name="tanggal_awal"
                                value="{{ request('tanggal_awal') }}">
                        </div>
                        <div class="col-3">
                            <input type="date" class="form-control" name="tanggal_akhir"
                                value="{{ request('tanggal_akhir') }}">
                        </div>
                        <div class="col-3">
                            <select name="pegawai_id" class="form-control">
                                <option value="">Pilih Pegawai</option>
                                @foreach ($pegawai as $peg)
                                    <option value="{{ $peg->id }}"
                                        {{ request('pegawai_id') == $peg->id ? 'selected' : '' }}>
                                        {{ $peg->nama_pegawai }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <select name="status" class="form-control">
                                <option value="">Pilih Status</option>
                                <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="Pulang" {{ request('status') == 'Pulang' ? 'selected' : '' }}>Pulang</option>
                                <option value="Sakit" {{ request('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                            </select>
                        </div>

                        <!-- Filter Button -->
                        <div class="col-1">
                            <button class="btn btn-primary form-control">Filter</button>
                        </div>
                    </div>

                    <!-- Export and Reset Buttons -->
                    <div class="row mt-3">
                        <div class="col-3">
                            <button type="submit" name="view_pdf" value="true" class="btn btn-danger">Export PDF</button>
                            <button type="submit" name="download_excel" value="true" class="btn btn-success">Export
                                Excel</button>
                            <a href="{{ route('laporan.absensi') }}" class="btn btn-secondary">Reset Filter</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
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
                        <tbody>
                            @foreach ($absensi as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->user ? $item->user->nama_pegawai : 'N/A' }}</td>
                                    <td>{{ $item->tanggal_absen }}</td>
                                    <td>{{ $item->jam_masuk }}</td>
                                    <td>{{ $item->jam_keluar }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>{{ $item->note }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>

    <script>
        new DataTable('#example')
    </script>
@endpush
