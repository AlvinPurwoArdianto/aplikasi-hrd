@extends('layouts.user.template')
@section('content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between">
                        <h6 class="text-white text-capitalize ps-3">Cuti</h6>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-light me-3" data-bs-toggle="modal" data-bs-target="#cutiModal">
                            Ajukan Cuti
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-center">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Cuti</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Alasan Cuti</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>    
                                </tr>
                            </thead>
                            <tbody class="text-center">
                            @foreach ($cuti as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_cuti)->translatedFormat('d F Y') }}</td>
                                    <td>{{ $item->alasan }}</td>
                                    <td>{{ $item->status }}</td>
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
                    <div class="mb-3">
                        <label for="tanggal_cuti" class="form-label">Tanggal Cuti</label>
                        <input type="date" class="form-control" id="tanggal_cuti" name="tanggal_cuti" required>
                    </div>
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

@endsection
