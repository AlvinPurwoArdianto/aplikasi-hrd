@extends('layouts.admin.template')
@section('css')
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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Laporan /</span> Laporan Pegawai</h4>
        <div class="card">
            <div class="card-header">
                <form action="{{ route('laporan.pegawai') }}" method="GET">
                    <div class="row">
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
                            <a href="{{ route('laporan.pegawai') }}" class="btn btn-danger form-control"
                                type="submit">Reset</a>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <select id="jabatan" name="jabatan" class="form-control">
                                <option class="text-center" value="" disabled
                                    {{ request('jabatan') ? '' : 'selected' }}>
                                    -- Pilih Jabatan--
                                </option>
                                @foreach ($jabatan as $data)
                                    <option value="{{ $data->id }}"
                                        {{ request('jabatan') == $data->id ? 'selected' : '' }}>
                                        {{ $data->nama_jabatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if (!$pegawai->isEmpty())
                        <div class="col-1">
                            <a href="#" id="lihatPdfButtonPegawai" class="btn btn-secondary form-control"
                                data-bs-toggle="modal" data-bs-target="#pdfModal">
                                <i class='bx bx-search-alt-2' data-bs-toggle="tooltip" data-bs-offset="0,4"
                                    data-bs-placement="bottom" data-bs-html="true" title="Lihat PDF"></i>
                            </a>
                        </div>
                            <div class="col-1">
                                <a href="{{ route('laporan.pegawai', ['download_pdf' => true, 'tanggal_awal' => request('tanggal_awal'), 'tanggal_akhir' => request('tanggal_akhir'), 'jabatan' => request('jabatan')]) }}"
                                    class="btn btn-danger form-control" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                    data-bs-placement="bottom" data-bs-html="true" title="Download PDF">
                                    <i class='bx bxs-file-pdf'></i>
                                </a>
                            </div>
                            <div class="col-1">
                                <a href="{{ route('laporan.pegawai', ['download_excel' => true, 'tanggal_awal' => request('tanggal_awal'), 'tanggal_akhir' => request('tanggal_akhir'), 'jabatan' => request('jabatan')]) }}"
                                    class="btn btn-success form-control" type="submit" data-bs-toggle="tooltip"
                                    data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true"
                                    title="Download EXCEL">
                                    <i class="bi bi-file-earmark-excel-fill"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="row mt-3">
                        <div class="col-3">
                            <select id="provinsi" name="provinsi" class="form-control">
                                <option value="" selected disabled>-- Pilih Provinsi --</option>
                                @foreach ($provinsi as $data)
                                    <option value="{{ $data['id'] }}" {{ request('provinsi') == $data['id'] ? 'selected' : '' }}>
                                        {{ $data['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <select id="kota" name="kota" class="form-control">
                                <option value="" selected disabled>-- Pilih Kota --</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <select id="kecamatan" name="kecamatan" class="form-control">
                                <option value="" selected disabled>-- Pilih Kecamatan --</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <select id="kelurahan" name="kelurahan" class="form-control">
                                <option value="" selected disabled>-- Pilih Kelurahan --</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                @if ($pegawai->isEmpty())
                    <div class="alert alert-warning" role="alert">
                        Tidak ada data pegawai ditemukan untuk tanggal yang dipilih atau jabatan yang dipilih.
                    </div>
                @else
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered" id="example">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pegawai</th>
                                    <th>Jabatan</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Umur</th>
                                    <th>Email</th>
                                    <th>Gaji</th>
                                    <th>Provinsi</th>
                                    <th>Kota</th>
                                    <th>Kabupaten</th>
                                    <th>Kelurahan</th>
                                </tr>
                            </thead>
                            <tbody id="myTable">
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($pegawai as $item)
                                    @if ($item->is_admin == 0)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->nama_pegawai }}</td>
                                            <td>{{ $item->jabatan ? $item->jabatan->nama_jabatan : 'Tidak ada jabatan' }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_masuk)->translatedFormat('d F Y') }}
                                            </td>
                                            <td>{{ $item->umur }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ 'Rp ' . number_format($item->gaji, 0, ',', '.') }}</td>
                                            <td>
                                                {{ $item->pegawai ? $item->pegawai->nama_provinsi : 'Tidak ada provinsi' }}
                                            </td>
                                            <td>
                                                {{ $item->pegawai ? $item->pegawai->nama_kota : 'Tidak ada kota' }}
                                            </td>
                                            <td>
                                                {{ $item->pegawai ? $item->pegawai->nama_kabupaten : 'Tidak ada kabupaten' }}
                                            </td>
                                            <td>
                                                {{ $item->pegawai ? $item->pegawai->nama_kelurahan : 'Tidak adakelurahan' }}
                                            </td>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
        // Ambil data kota berdasarkan provinsi yang dipilih
       // Fetch cities based on the selected province
$('#provinsi').change(function() {
    var provinsiId = $(this).val();
    if (provinsiId) {
        $.ajax({
            url: '/get-kota/' + provinsiId, // Ensure this endpoint exists and returns data
            type: 'GET',
            success: function(data) {
                if (data && Array.isArray(data)) {
                    $('#kota').empty();
                    $('#kota').append('<option value="" selected disabled>-- Pilih Kota --</option>');
                    $.each(data, function(index, item) {
                        $('#kota').append('<option value="'+ item.id +'">'+ item.name +'</option>');
                    });
                    // Clear other dropdowns
                    $('#kecamatan').empty().append('<option value="" selected disabled>-- Pilih Kecamatan --</option>');
                    $('#kelurahan').empty().append('<option value="" selected disabled>-- Pilih Kelurahan --</option>');
                } else {
                    alert('No data received for cities.');
                }
            },
            error: function() {
                alert('Failed to fetch cities data.');
            }
        });
    }
});

    
        // Ambil data kecamatan berdasarkan kota yang dipilih
        $('#kota').change(function() {
    var kotaId = $(this).val();
    if (kotaId) {
        $.ajax({
            url: '/get-kecamatan/' + kotaId,  // Make sure this API returns the districts
            type: 'GET',
            success: function(data) {
                $('#kecamatan').empty();
                $('#kecamatan').append('<option value="" selected disabled>-- Pilih Kecamatan --</option>');
                $.each(data, function(index, item) {
                    $('#kecamatan').append('<option value="'+ item.id +'">'+ item.name +'</option>');
                });
                $('#kelurahan').empty().append('<option value="" selected disabled>-- Pilih Kelurahan --</option>');
            }
        });
    }
});

$('#kecamatan').change(function() {
    var kecamatanId = $(this).val();
    if (kecamatanId) {
        $.ajax({
            url: '/get-kelurahan/' + kecamatanId,  // Make sure this API returns the villages
            type: 'GET',
            success: function(data) {
                $('#kelurahan').empty();
                $('#kelurahan').append('<option value="" selected disabled>-- Pilih Kelurahan --</option>');
                $.each(data, function(index, item) {
                    $('#kelurahan').append('<option value="'+ item.id +'">'+ item.name +'</option>');
                });
            }
        });
    }
});

    </script>
<script>
    document.getElementById('lihatPdfButtonCuti').addEventListener('click', function() {
    var pegawai = document.querySelector('#pegawai').value || '';
    var tanggalAwal = document.querySelector('input[name="tanggal_awal"]').value || '';
    var tanggalAkhir = document.querySelector('input[name="tanggal_akhir"]').value || '';
    var statusCuti = document.querySelector('#status_cuti').value || '';

    // Buat URL dengan parameter filter
    var url = "{{ route('laporan.cuti.lihat-pdf') }}" +
        "?pegawai=" + encodeURIComponent(pegawai) +
        "&tanggal_awal=" + encodeURIComponent(tanggalAwal) +
        "&tanggal_akhir=" + encodeURIComponent(tanggalAkhir) +
        "&status_cuti=" + encodeURIComponent(statusCuti);

    // Log URL untuk debugging
    console.log("PDF URL: ", url);

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
