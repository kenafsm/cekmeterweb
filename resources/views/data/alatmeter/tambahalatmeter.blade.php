@extends('layout.dashboard-layout')

@section('title','Admin Dashboard - CekMeter PUDAM')

@section('main-content')
<div class="container-fluid">
    <div class="card card-info card-outline">
        <div class="card-header bg-primary">
            <h3 style="color:white;">Form Tambah Data Alat Meter</h3>
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
            <form action="{{ route('alatmeter.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama_merk">Nama Merk Meter</label>
                    <input type="text" id="nama_merk" name="nama_merk" class="form-control"
                        placeholder="Masukan Nama Merk Meter" required>
                </div>
                <div class="form-group">
                    <label for="deskripsi">No Seri</label>
                    <input type="text" id="no_seri" name="no_seri" class="form-control"
                        placeholder="Masukan Nomor Seri" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                    <button type="reset" class="btn btn-danger">Reset Data</button>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection
