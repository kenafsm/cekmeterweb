@extends('layout.dashboard-layout')

@section('title','Admin Dashboard - Edit Pelanggan')

@section('main-content')
<div class="container-fluid">
    <div class="card card-info card-outline">
        <div class="card-header bg-primary">
            <h3 style="color:white;">Form Edit Data Pelanggan</h3>
            @if ($errors->any())
            <div class="alert alert-danger my-3">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if (Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if (Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                {{ Session::get('danger') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
        </div>
        <div class="card-body">
            <form action="{{ route('pelanggan.update', $pelanggan->no_sp) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Menggunakan method PUT untuk update -->
                <div class="form-group">
                    <label for="no_sp">Nomor SP</label>
                    <div class="row">
                        <div class="col-md-1">
                            <input type="text" id="kode_wilayah" name="kode_wilayah" class="form-control"
                                placeholder="Kode" maxlength="2" value="{{ substr($pelanggan->no_sp, 0, 2) }}"
                                required oninput="updateNoSP()">
                        </div>
                        <div class="col-md-11">
                            <input type="text" id="no_sp_lain" name="no_sp_lain" class="form-control"
                                placeholder="Masukan Sisa Nomor SP"
                                value="{{ substr($pelanggan->no_sp, 2) }}"
                                required
                                maxlength="5"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 5); updateNoSP()">
                        </div>                        
                    </div>
                </div>
                <!-- Menampilkan Nomor SP Lengkap di dalam label -->
                <div class="form-group" id="reviewSection" style="display: none;">
                    <h6>Review</h6>
                    <table style="border-collapse: collapse;">
                        <tr>
                            <td>Nomor SP Pelanggan</td>
                            <td>:</td>
                            <td><span id="review_no_sp"></span></td>
                        </tr>
                        <tr>
                            <td>Wilayah</td>
                            <td>:</td>
                            <td><span id="review_wilayah"></span></td>
                        </tr>
                    </table>
                </div>
                <div class="form-group">
                    <label for="nama">Nama Pelanggan</label>
                    <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="form-control"
                        placeholder="Masukan Nama Pelanggan" value="{{ $pelanggan->nama_pelanggan }}" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <input type="text" id="status" name="status" class="form-control"
                        placeholder="Masukan Status" value="{{ $pelanggan->status }}" required>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat Pelanggan</label>
                    <textarea type="text" id="alamat" name="alamat" class="form-control"
                        required>{{ $pelanggan->alamat }}</textarea>
                </div>
                <div class="form-group">
                    <label for="tahun_instalasi">Tahun Instalasi</label>
                    <input type="text" id="tahun_instalasi" name="tahun_instalasi" class="form-control"
                        placeholder="Masukan Tahun Instalasi" value="{{ $pelanggan->tahun_instalasi }}" required
                        maxlength="4"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);">
                </div>
                <div class="form-group">
                    <label for="tahun_kadaluarsa">Tahun Kadaluarsa</label>
                    <input type="text" id="tahun_kadaluarsa" name="tahun_kadaluarsa" class="form-control"
                        placeholder="Masukan Tahun Kadaluarsa" value="{{ $pelanggan->tahun_kadaluarsa }}" required
                        maxlength="4"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);">
                </div>
                <div class="form-group">
                    <label for="staf_nip">NIP Staf</label>
                    <select class="form-control" id="staf_nip" name="staf_nip" required>
                        <option value="">Pilih Staf</option>
                        @foreach($staflapangan as $staflpangan)
                        <option value="{{ $staflpangan->nip }}"
                            {{ old('staf_nip', $logdata ? $logdata->staf_nip : '') == $staflpangan->nip ? 'selected' : '' }}>
                            {{ $staflpangan->nip }} - {{ $staflpangan->nama_staff }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Data</button>
                    <button type="reset" class="btn btn-danger" onclick="resetNoSP()">Reset Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
