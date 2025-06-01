@extends('layout.dashboard-layout')

@section('title','Admin Dashboard - CekMeter PUDAM')

@section('main-content')
<div class="container-fluid">
    <div class="card card-info card-outline">
        <div class="card-header bg-primary">
            <h3 style="color:white;">Edit Tambah Data Merk Meter</h3>
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
            <form action="{{ route('merkmeter.update', $merks->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama_merk">Nama Merk Meter</label>
                    <input type="text" id="nama_merk" name="nama_merk" class="form-control" placeholder="Masukan Nama Merk Meter" value="{{old('nama_merk', $merks->nama_merk)}}">
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi Merk Meter</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5" placeholder="Masukan Deskripsi atau Spesifikasi Merk Meter">{{old('nama_merk', $merks->deskripsi)}}</textarea>
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
