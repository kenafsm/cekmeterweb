@extends('layout.dashboard-layout')

@section('title','Admin Dashboard - Tambah Pelanggan')

@section('main-content')
<div class="container-fluid">
    <div class="card card-info card-outline">
        <div class="card-header bg-primary">
            <h3 style="color:white;">Form Tambah Data Pelanggan</h3>
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
            <form action="{{ route('pelanggan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="no_sp">Nomor SP</label>
                    <div class="row">
                        <div class="col-md-1">
                            <select id="kode_wilayah" name="kode_wilayah" class="form-control" required onchange="updateNoSP()">
                                <option value="" disabled selected>Pilih</option>
                                @foreach ($wilayah as $wilayah)
                                    <option value="{{ $wilayah['kode_wilayah'] }}">{{ $wilayah['kode_wilayah'] }} - {{ $wilayah['nama_wilayah'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-11">
                            <input type="number" id="no_sp_lain" name="no_sp_lain" class="form-control"
                                placeholder="Masukan Sisa Nomor SP" required
                                maxlength="5"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 5); updateNoSP()">
                        </div>                        
                    </div>
                </div>
                <!-- Menampilkan Review -->
                <div class="form-group" id="reviewSection" style="display: none;">
                    <h6><strong>Review</strong></h6>
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
                        placeholder="Masukan Nama Pelanggan" required>
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
                    <label for="alamat">Alamat Pelanggan</label>
                    <textarea type="text" id="alamat" name="alamat" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="tahun_instalasi">Tahun Instalasi</label>
                    <input type="number" id="tahun_instalasi" name="tahun_instalasi" class="form-control" 
                        placeholder="Masukan Tahun Instalasi" required 
                        maxlength="4"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);">
                </div>                
                <div class="form-group">
                    <label for="tahun_kadaluarsa">Tahun Kadaluarsa</label>
                    <input type="number" id="tahun_kadaluarsa" name="tahun_kadaluarsa" class="form-control" 
                        placeholder="Masukan Tahun Kadaluarsa" required
                        maxlength="4"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);">
                </div>
                <div class="form-group">
                    <label for="staf_nip">NIP Staf</label>
                    <select class="form-control" id="staf_nip" name="staf_nip" required>
                        <option value="">Pilih Staf Lapangan</option>
                        @foreach($staflapangan as $staflapangan)
                        <option value="{{ $staflapangan->nip }}">{{ $staflapangan->nip }} - {{ $staflapangan->nama_staff }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                    <button type="reset" class="btn btn-danger" onclick="resetNoSP()">Reset Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
{{-- @endif --}}
