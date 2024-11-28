@extends('layouts.user.template')
@section('content')
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <style>
        .badge-custom {
            font-weight: bold;
            color: black;
            background-color: #d1ecf1;
            /* Sesuaikan dengan warna yang Anda inginkan */
        }
    </style>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div
                            class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between">
                            <h6 class="text-white text-capitalize ps-3">Cuti</h6>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-light me-3" data-bs-toggle="modal"
                                data-bs-target="#cutiModal">
                                Ajukan Cuti
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0 text-center">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            tanggal Mengajukan</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Tanggal Mulai</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Tanggal Selesai</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Kategori Cuti</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Alasan Cuti</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($cuti as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d F Y') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d F Y') }}
                                            <td>
                                                @if ($item->kategori_cuti === 'acara_keluarga')
                                                    Acara Keluarga
                                                @elseif ($item->kategori_cuti === 'liburan')
                                                    Liburan
                                                @elseif($item->kategori_cuti === 'hamil')
                                                    Hamil
                                                @endif
                                            </td>
                                            </td>
                                            <td>{{ $item->alasan }}</td>
                                            <td style="color: black;">
                                                @if ($item->status_cuti === 'Diterima')
                                                    <span class="badge bg-info text-dark" style="font-weight: bold;">—
                                                        Diterima —</span>
                                                @elseif ($item->status_cuti === 'Ditolak')
                                                    <span class="badge bg-danger text-white" style="font-weight: bold;">—
                                                        Ditolak —</span>
                                                @else
                                                    <span class="badge bg-dark text-white" style="font-weight: bold;">—
                                                        Menunggu Konfirmasi —</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Ajukan Cuti -->
    <div class="modal fade" id="cutiModal" tabindex="-1" aria-labelledby="cutiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cutiModalLabel">Ajukan Cuti</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('cuti.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_user" value="{{ Auth::id() }}">

                        <!-- Tanggal Cuti -->
                        <div class="mb-3">
                            <label for="tanggal_cuti" class="form-label">Tanggal Mulai Cuti</label>
                            <input type="date" class="form-control" id="tanggal_cuti" name="tanggal_cuti" required>
                        </div>

                        <!-- Input untuk Tanggal Selesai Cuti -->
                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai Cuti</label>
                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                        </div>

                        <!-- radio kategori cuti -->
                        <div class="mb-3">
                            <label for="kategori_cuti" class="form-label">Kategori Cuti</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="kategori_cuti" id="acara_keluarga"
                                    value="acara_keluarga" required>
                                <label class="form-check-label" for="acara_keluarga">
                                    Acara Keluarga
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="kategori_cuti" id="liburan"
                                    value="liburan" required>
                                <label class="form-check-label" for="liburan">
                                    Liburan
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="kategori_cuti" id="cuti_mengajar"
                                    value="cuti_mengajar" required>
                                <label class="form-check-label" for="cuti_mengajar">
                                    Hamil
                                </label>
                            </div>
                        </div>

                        <!-- Alasan Cuti -->
                        <div class="mb-3">
                            <label for="alasan" class="form-label">Alasan Cuti</label>
                            <textarea class="form-control" id="alasan" name="alasan" rows="3" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Ajukan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ $errors->first() }}',
            });
        </script>
    @endif
@endsection
