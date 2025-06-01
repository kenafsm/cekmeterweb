@extends('layout.dashboard-layout')

@section('title','Admin Dashboard - Data Pelanggan')

@section('main-content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Pelanggan PUDAM Banyuwangi</h1>
        <a href="{{ route('pelanggan.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-plus fa-sm text-white-50"></i> Tambah Data <i></i></a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Nomor SP</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Wilayah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pelanggan as $index => $object)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $object ->no_sp }}</td>
                            <td>{{ $object ->nama_pelanggan }}</td>
                            <td>{{ $object ->alamat }}</td>
                            <td>{{ $object ->wilayah->nama_wilayah }}</td>
                            <td>
                                <!-- Update Button -->
                                <a href="{{ route('pelanggan.edit', $object->id)}}" class="btn btn-info"><i
                                        class="fas fa-edit"></i></a>
                                <!-- Delete Button -->
                                <form id="delete-form-{{ $object->id }}" action="{{route('pelanggan.destroy', $object->id)}}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <!-- Perbaikan tombol delete -->
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $object->id }})">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        {{-- @empty
                        <tr>
                            <td colspan="10" class="text-center">Data Masih Kosong</td>
                        </tr> --}}
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection
