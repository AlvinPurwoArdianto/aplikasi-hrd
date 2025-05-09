@extends('layouts.admin.template')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Menu /</span> Berkas Pribadi</h4>

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

        <div class="card mb-4 pb-2">
            <h5 class="card-header">
                <button type="button" class="btn rounded-pill btn-info" data-bs-toggle="modal"
                    data-bs-target="#createModal"
                    style="float: right; padding-left: 20px; padding-right: 20px; padding-top: 7px; padding-bottom: 7px">
                    <i class="bi bi-person-fill-add" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="left"
                        data-bs-html="true" title="Add berkas"></i>
                    Add Berkas
                </button>
                Add Berkas
            </h5>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>CV</th>
                            <th>KK</th>
                            <th>KTP</th>
                            <th>AKTE</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($berkas as $data)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $data->pegawai->nama_pegawai }}</td>
                                
                                <!-- Conditional check for CV -->
                                <td>
                                    @if ($data->file_cv)
                                        <a href="javascript:void(0)" class="btn rounded-pill btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#viewCVModal{{ $data->id }}"
                                            style="padding-left: 20px; padding-right: 20px; padding-top: 7px; padding-bottom: 7px">
                                            <i class="bx bx-search-alt" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                data-bs-placement="left" data-bs-html="true" title="Lihat CV"></i>
                                        </a>
                                    @else
                                        <span>No CV</span>
                                    @endif
                                </td>
                    
                                <!-- Conditional check for KK -->
                                <td>
                                    @if ($data->file_kk)
                                        <a href="javascript:void(0)" class="btn rounded-pill btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#viewKKModal{{ $data->id }}"
                                            style="padding-left: 20px; padding-right: 20px; padding-top: 7px; padding-bottom: 7px">
                                            <i class="bx bx-search-alt" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                data-bs-placement="left" data-bs-html="true" title="Lihat KK"></i>
                                        </a>
                                    @else
                                        <span>No KK</span>
                                    @endif
                                </td>
                    
                                <!-- Conditional check for KTP -->
                                <td>
                                    @if ($data->file_ktp)
                                        <a href="javascript:void(0)" class="btn rounded-pill btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#viewKTPModal{{ $data->id }}"
                                            style="padding-left: 20px; padding-right: 20px; padding-top: 7px; padding-bottom: 7px">
                                            <i class="bx bx-search-alt" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                data-bs-placement="left" data-bs-html="true" title="Lihat KTP"></i>
                                        </a>
                                    @else
                                        <span>No KTP</span>
                                    @endif
                                </td>
                    
                                <!-- Conditional check for AKTE -->
                                <td>
                                    @if ($data->file_akte)
                                        <a href="javascript:void(0)" class="btn rounded-pill btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#viewAKTEModal{{ $data->id }}"
                                            style="padding-left: 20px; padding-right: 20px; padding-top: 7px; padding-bottom: 7px">
                                            <i class="bx bx-search-alt" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                data-bs-placement="left" data-bs-html="true" title="Lihat AKTE"></i>
                                        </a>
                                    @else
                                        <span>No AKTE</span>
                                    @endif
                                </td>
                    
                                <td>
                                    <form action="{{ route('berkas.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn rounded-pill btn-danger"
                                            data-confirm-delete="true"><i class="bx bx-trash me-1"></i>
                                            Delete</button>
                                    </form>
                                </td>
                            </tr>
                    
                            <!-- Modals for each file (CV, KK, KTP, AKTE) -->
                            @if ($data->file_cv)
                                <div class="modal fade" id="viewCVModal{{ $data->id }}" tabindex="-1"
                                    aria-hidden="true" data-bs-backdrop="static">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Lihat CV - {{ $data->pegawai->nama_pegawai }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="embed-responsive" style="height: 500px;">
                                                    <embed src="{{ Storage::url($data->file_cv) }}" type="application/pdf"
                                                        width="100%" height="100%">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                    
                            @if ($data->file_kk)
                                <div class="modal fade" id="viewKKModal{{ $data->id }}" tabindex="-1"
                                    aria-hidden="true" data-bs-backdrop="static">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Lihat KK - {{ $data->pegawai->nama_pegawai }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="embed-responsive" style="height: 500px;">
                                                    <embed src="{{ Storage::url($data->file_kk) }}" type="application/pdf"
                                                        width="100%" height="100%">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                    
                            @if ($data->file_ktp)
                                <div class="modal fade" id="viewKTPModal{{ $data->id }}" tabindex="-1"
                                    aria-hidden="true" data-bs-backdrop="static">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Lihat KTP - {{ $data->pegawai->nama_pegawai }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="embed-responsive" style="height: 500px;">
                                                    <embed src="{{ Storage::url($data->file_ktp) }}" type="application/pdf"
                                                        width="100%" height="100%">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                    
                            @if ($data->file_akte)
                                <div class="modal fade" id="viewAKTEModal{{ $data->id }}" tabindex="-1"
                                    aria-hidden="true" data-bs-backdrop="static">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Lihat AKTE - {{ $data->pegawai->nama_pegawai }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="embed-responsive" style="height: 500px;">
                                                    <embed src="{{ Storage::url($data->file_akte) }}" type="application/pdf"
                                                        width="100%" height="100%">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Create berkas -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add berkas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('berkas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row mt-3">
                            <div class="col mb-0 ">
                                <label for="nameBasic" class="form-label">Nama Pegawai</label>
                                <select name="id_user" class="form-control" required>
                                    <option selected disabled>-- Pilih Nama Pegawai --</option>
                                    @foreach ($pegawai as $item)
                                        @if ($item->is_admin == 0)
                                            <option value="{{ $item->id }}">{{ $item->nama_pegawai }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col mb-0 mt-3">
                                <label for="nameBasic" class="form-label">Masukan CV Anda</label>
                                <input type="file" class="form-control" name="cv" accept="application/pdf">
                            </div>
                            <div class="col mb-0 mt-3">
                                <label for="nameBasic" class="form-label">Masukan KK Anda</label>
                                <input type="file" class="form-control" name="kk" accept="application/pdf">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col mb-0 mt-3">
                                <label for="nameBasic" class="form-label">Masukan KTP Anda</label>
                                <input type="file" class="form-control" name="ktp" accept="application/pdf">
                            </div>
                            <div class="col mb-0 mt-3">
                                <label for="nameBasic" class="form-label">Masukan AKTE Anda</label>
                                <input type="file" class="form-control" name="akte" accept="application/pdf">
                            </div>
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
