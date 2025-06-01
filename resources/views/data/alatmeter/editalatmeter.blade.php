@extends('layout.dashboard-layout')

@section('title','Admin Dashboard - CekMeter PUDAM')

@section('main-content')
<div class="container-fluid">
    <div class="card card-info card-outline">
        <div class="card-header bg-primary">
            <h3 style="color:white;">Edit Tambah Data Alat Meter</h3>
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
            <form action="{{ route('alatmeter.update', $alatmeters->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama_merk">Nama Merk Meter</label>
                    <input type="text" id="nama_merk" name="nama_merk" class="form-control" placeholder="Masukan Nama Merk Meter" value="{{old('nama_merk', $alatmeters->nama_merk)}}">
                </div>
                <div class="form-group">
                    <label for="no_seri">No Seri Merk Meter</label>
                    <textarea name="no_seri" id="no_seri" class="form-control" rows="5" placeholder="Masukan Deskripsi Nomor Seri">{{old('nama_merk', $alatmeters->no_seri)}}</textarea>
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
