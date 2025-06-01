@extends('layout.dashboard-layout')

@section('title','Admin Dashboard - Merk Meter')

@section('main-content')


<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Merk Meter</h1>
        <a href="{{ route('merkmeter.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
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
                            <th>Nama Merk</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($merks as $merk)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $merk->nama_merk }}</td>
                            <td>{{ $merk->deskripsi ?? 'Tidak Ada Deskripsi dari Merk Meter Ini' }}</td>
                            <td>
                                <!-- Update Button -->
                                <a href="{{ route('merkmeter.edit', $merk->id) }}" class="btn btn-info"><i
                                        class="fas fa-edit"></i></a>
                                <!-- Delete Button -->
                                <form id="delete-form-{{ $merk->id }}" action="{{ route('merkmeter.destroy', $merk->id) }}" method="POST" class="d-inline">
                                    @method('DELETE')
                                    @csrf
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $merk->id }})"><i
                                            class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection
