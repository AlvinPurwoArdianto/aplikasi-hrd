@extends('layouts.admin.template')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Employee /</span> Jabatan</h4>

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
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"
                    style="float: right; padding-left: 20px; padding-right: 20px; padding-top: 7px; padding-bottom: 7px">
                    <i class="bi bi-person-fill-add" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="left"
                        data-bs-html="true" title="Add Jabatan"></i>
                    Add Jabatan
                </button>
                Add Jabatan
            </h5>

            <!-- Table for Jabatan Data -->
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Jabatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($jabatan as $data)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $data->nama_jabatan }}</td>
                                <td>
                                    <form action="{{ route('jabatan.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a href="javascript:void(0)" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $data->id }}"
                                            style="padding-left: 20px; padding-right: 20px; padding-top: 7px; padding-bottom: 7px">
                                            <i class="bi bi-pencil-square" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                data-bs-placement="left" data-bs-html="true" title="Edit Jabatan"></i>
                                            Edit
                                        </a>

                                        <a href="{{ route('jabatan.destroy', $data->id) }}" class="btn btn-sm btn-danger"
                                            data-confirm-delete="true"
                                            style="padding-left: 20px; padding-right: 20px; padding-top: 7px; padding-bottom: 7px">
                                            <i class="bi bi-trash-fill" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                data-bs-placement="right" data-bs-html="true" title="Delete Jabatan"></i>
                                            Delete
                                        </a>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Edit Jabatan -->
                            <div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1" aria-hidden="true"
                                data-bs-backdrop="static">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Jabatan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('jabatan.update', $data->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
                                                    <input type="text" class="form-control" name="nama_jabatan"
                                                        value="{{ $data->nama_jabatan }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
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

    <!-- Modal Create Jabatan -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Jabatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('jabatan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
                            <input type="text" class="form-control" name="nama_jabatan" placeholder="Enter jabatan"
                                required>
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
