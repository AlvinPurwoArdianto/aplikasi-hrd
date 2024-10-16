@extends('layouts.admin.template')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Employee /</span> Rekrutmen</h4>

        {{-- UNTUK TOAST NOTIFIKASI --}}
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="validationToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <i class="bi bi-cloud-arrow-up-fill me-2"></i>
                    <div class="me-auto fw-semibold">Success</div>
                    <small>Just Now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Data sudah ada!
                </div>
            </div>
        </div>


        <!-- Toast Untuk Success -->
        @if (session('success'))
            <div class="bs-toast toast toast-placement-ex m-2 bg-success top-0 end-0 fade show toast-custom" role="alert"
                aria-live="assertive" aria-atomic="true" id="toastSuccess">
                <div class="toast-header">
                    <i class="bi bi-check-circle me-2"></i>
                    <div class="me-auto fw-semibold">Success</div>
                    <small>Just Now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        @endif

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


        {{-- Toast Untuk Danger --}}
        @if (session('danger'))
            <div class="bs-toast toast toast-placement-ex m-2 bg-danger top-0 end-0 fade show toast-custom" role="alert"
                aria-live="assertive" aria-atomic="true" id="toastError">
                <div class="toast-header">
                    <i class="bx bx-error me-2"></i>
                    <div class="me-auto fw-semibold">Danger</div>
                    <small>Just Now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('danger') }}
                </div>
            </div>
        @endif

        {{-- Toast Untuk Warning --}}
        @if (session('warning'))
            <div class="bs-toast toast toast-placement-ex m-2 bg-warning top-0 end-0 fade show toast-custom" role="alert"
                aria-live="assertive" aria-atomic="true" id="toastError">
                <div class="toast-header">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <div class="me-auto fw-semibold">Warning</div>
                    <small>Just Now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('warning') }}
                </div>
            </div>
        @endif


        <div class="card">
            <h5 class="card-header">
                <button type="button" class="btn rounded-pill btn-info" data-bs-toggle="modal"
                    data-bs-target="#createModal"
                    style="float: right; padding-left: 20px; padding-right: 20px; padding-top: 7px; padding-bottom: 7px">
                    <i class="bi bi-person-fill-add" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="left"
                        data-bs-html="true" title="Add rekrutmen"></i>
                    Add Rekrutmen
                </button>
                Add Rekrutmen
            </h5>

            <!-- Table for Rekrutmen Data -->
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>tanggal lamaran</th>
                            <th>CV</th>
                            <th>status lamaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($rekrutmen as $data)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->tanggal_lamaran }}</td>
                                <td>
                                    <a href="javascript:void(0)" class="btn rounded-pill btn-primary"
                                        style="padding-left: 20px; padding-right: 20px; padding-top: 7px; padding-bottom: 7px">
                                        <i class="bx bx-search-alt" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                            data-bs-placement="left" data-bs-html="true" title="Edit rekrutmen"></i>
                                        Lihat
                                    </a>

                                    {{-- {{ $data->cv }} --}}
                                </td>
                                <td>

                                </td>
                                <td>
                                    <form action="{{ route('rekrutmen.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a href="javascript:void(0)" class="btn rounded-pill btn-primary"
                                            data-bs-toggle="modal" data-bs-target="#editModal{{ $data->id }}"
                                            style="padding-left: 20px; padding-right: 20px; padding-top: 7px; padding-bottom: 7px">
                                            <i class="bi bi-pencil-square" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                data-bs-placement="left" data-bs-html="true" title="Edit rekrutmen"></i>
                                            Edit
                                        </a>

                                        <a href="{{ route('rekrutmen.destroy', $data->id) }}"
                                            class="btn rounded-pill btn-danger" data-confirm-delete="true"
                                            style="padding-left: 20px; padding-right: 20px; padding-top: 7px; padding-bottom: 7px">
                                            <i class="bi bi-trash-fill" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                data-bs-placement="right" data-bs-html="true"
                                                title="Delete rekrutmen"></i>
                                            Delete
                                        </a>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Edit rekrutmen -->
                            <div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1" aria-hidden="true"
                                data-bs-backdrop="static">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit rekrutmen</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('rekrutmen.update', $data->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col mb-0">
                                                        <label for="nameBasic" class="form-label">Nama</label>
                                                        <input type="text" class="form-control" name="nama"
                                                            required>
                                                    </div>
                                                    <div class="col mb-0">
                                                        <label for="nameBasic" class="form-label">Tanggal Lamaran</label>
                                                        <input type="date" class="form-control" name="tanggal_lamaran"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col mb-0">
                                                    <label for="nameBasic" class="form-label">Masukan CV Anda</label>
                                                    <input type="file" class="form-control" name="cv" required
                                                        accept="application/pdf">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Create Rekrutmen -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Rekrutmen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('rekrutmen.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row mt-3">
                            <div class="col mb-0 ">
                                <label for="nameBasic" class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama" required>
                            </div>
                            <div class="col mb-0">
                                <label for="nameBasic" class="form-label">Tanggal Lamaran</label>
                                <input type="date" class="form-control" name="tanggal_lamaran" required>
                            </div>
                        </div>
                        <div class="col mb-0 mt-3">
                            <label for="nameBasic" class="form-label">Masukan CV Anda</label>
                            <input type="file" class="form-control" name="cv" required accept="application/pdf">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
