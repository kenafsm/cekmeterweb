@extends('layout.dashboard-layout')

@section('title','Admin Dashboard - Data Staff')

@section('main-content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header bg-primary">
            <h3 style="color:white;">Form Ubah Data Staff/User</h3>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
        <div class="card-body">
            <form action="{{ route('staflapangan.update', $staflapangans->nip) }}" method="POST">
            @csrf
            @method('PUT')
                <div class="form-group">
                    <label for="nip" class="form-label">NIP</label>
                    <input type="number" class="form-control" id="nip" name="nip" value="{{ $staflapangans->nip }}" required
                    maxlength="5"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 5);">
                </div>
                <div class="form-group">
                    <label for="namastaff" class="form-label">Nama Staff</label>
                    <input type="text" class="form-control" id="namastaff"  name="nama_staff" value="{{ $staflapangans->nama_staff }}" required>
                </div>
                <div class="form-group">
                    <label for="notelepon" class="form-label">No. Telepon</label>
                    <input type="number" class="form-control" id="notelepon" name="no_telepon" value="{{ $staflapangans->no_telepon }}" required>
                </div>
                <div class="form-group">
                    <label for="target_cek" class="form-label">Target Cek</label>
                    <input type="number" class="form-control" id="target_cek" name="target_cek" required value="{{ $staflapangans->target_cek }}">
                </div>
                <div class="form-group">
                    <label for="wilayah" class="form-label">Wilayah</label>
                    <select id="kode_wilayah" name="kode_wilayah" class="form-control" required>
                        <option value="" disabled>Pilih Wilayah</option>
                        @foreach ($wilayah as $wilayah)
                            <option value="{{ $wilayah['kode_wilayah'] }}"
                                {{ $wilayah['kode_wilayah'] == $staflapangans->kode_wilayah ? 'selected' : '' }}>
                                {{ $wilayah['kode_wilayah'] }} - {{ $wilayah['nama_wilayah'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="" disabled selected>Pilih Status</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" value="{{ $staflapangans->password }}" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Ubah Data</button>
                    <button type="reset" class="btn btn-danger">Reset Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
