@extends('layouts.admin.template')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Management Karyawan /</span> <span
                class="text-muted fw-light">Pegawai /</span> Edit</h4>

        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Edit pegawai</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Nama Lengkap</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control" id="basic-icon-default-fullname"
                                    placeholder="Masukan Nama Lengkap" name="nama_pegawai"
                                    value="{{ old('nama_pegawai', $pegawai->nama_pegawai) }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Umur</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <input type="number" class="form-control" id="basic-icon-default-fullname"
                                    placeholder="Masukan Umur Anda" name="umur"
                                    value="{{ old('umur', $pegawai->umur) }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Jabatan</label>
                        <div class="col-sm-10">
                            <select name="id_jabatan" class="form-control">
                                <option selected disabled>-- Pilih Jabatan --</option>
                                @foreach ($jabatan as $data)
                                    <option value="{{ $data->id }}"
                                        {{ $data->id == $pegawai->id_jabatan ? 'selected' : '' }}>
                                        {{ $data->nama_jabatan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Jenis Kelamin</label>
                        <div class="col-sm-10">
                            <select name="jenis_kelamin" class="form-control">
                                <option value="" disabled>-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-Laki" {{ $pegawai->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' }}>
                                    Laki-Laki</option>
                                <option value="Perempuan" {{ $pegawai->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Tempat & Tanggal
                            Lahir</label>
                        <div class="col-sm-5">
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control" id="basic-icon-default-fullname"
                                    placeholder="Tempat Lahir" name="tempat_lahir"
                                    value="{{ old('tempat_lahir', $pegawai->tempat_lahir) }}" />
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group input-group-merge">
                                <input type="date" class="form-control" id="basic-icon-default-fullname"
                                    placeholder="Tanggal Lahir" name="tanggal_lahir"
                                    value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir) }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Alamat</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <textarea type="text" class="form-control" id="basic-icon-default-fullname" placeholder="Masukan Alamat Anda"
                                    name="alamat">{{ old('alamat', $pegawai->alamat) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Email</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <input type="email" class="form-control" id="basic-icon-default-fullname"
                                    placeholder="Masukan Email Anda" name="email"
                                    value="{{ old('email', $pegawai->email) }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Tanggal Masuk</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <input type="date" class="form-control" id="basic-icon-default-fullname"
                                    placeholder="Tanggal pegawai" name="tanggal_masuk"
                                    value="{{ old('tanggal_masuk', $pegawai->tanggal_masuk) }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Gaji</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <input type="number" class="form-control" id="basic-icon-default-fullname"
                                    placeholder="Masukan Gaji Awal" name="gaji"
                                    value="{{ old('gaji', $pegawai->gaji) }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Status Pegawai</label>
                        <div class="col-sm-10">
                            <select name="status_pegawai" class="form-control">
                                <option selected disabled>-- Pilih Status Pegawai --</option>
                                <option value="1" {{ $pegawai->status_pegawai == 1 ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="0" {{ $pegawai->status_pegawai == 0 ? 'selected' : '' }}>Tidak Aktif
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <a href="{{ route('pegawai.index') }} " class="btn btn-primary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
