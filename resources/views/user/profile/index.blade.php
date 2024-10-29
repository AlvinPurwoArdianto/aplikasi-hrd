@extends('layouts.user.template')

@section('content')

    <div class="main-content position-relative max-height-vh-100 h-100">
        <div class="card shadow-lg mx-4 card-profile-bottom">
            <div class="card-body p-3">
                <div class="row gx-4">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <img src="{{ asset('user/assets/img/team-1.jpg') }}" alt="profile_image"
                                class="w-100 border-radius-lg shadow-sm">
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ Auth::user()->nama_pegawai }} <!-- Nama pengguna -->
                            </h5>
                            <p class="mb-0">
                                {{ Auth::user()->jabatan->nama_jabatan ?? 'Jabatan tidak ditemukan' }} <!-- Jabatan -->
                            </p>
                        </div>
                    </div>
                </div>
                <hr class="horizontal dark mt-0">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tempat_lahir" value="{{ Auth::user()->tempat_lahir }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" value="{{ Auth::user()->tanggal_lahir }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <input type="text" class="form-control" id="jenis_kelamin" value="{{ Auth::user()->jenis_kelamin }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" id="alamat" value="{{ Auth::user()->alamat }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_masuk">Tanggal Masuk</label>
                            <input type="date" class="form-control" id="tanggal_masuk" value="{{ Auth::user()->tanggal_masuk }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="umur">Umur</label>
                            <input type="text" class="form-control" id="umur" value="{{ Auth::user()->umur }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="gaji">Gaji</label>
                            <input type="text" class="form-control" id="gaji" value="{{ Auth::user()->gaji }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="status_pegawai">Status Pegawai</label>
                            <input type="text" class="form-control" id="status_pegawai" value="{{ Auth::user()->status_pegawai }}" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
