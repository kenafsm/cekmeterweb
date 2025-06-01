@extends('layout.dashboard-layout')

@section('title','Admin Dashboard - Merk Meter')

@section('main-content')


<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex flex-wrap justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Alat Meter - CekMeter Air PUDAM Banyuwangi</h1>
        @if(auth()->user()->role !== 'staf_spi')
        <a href="{{ route('alatmeter.create') }}" class="btn btn-sm btn-primary shadow-sm d-sm-inline-block d-block"><i
                class="fas fa-plus fa-sm text-white-50"></i> Tambah Data <i></i></a>
        @endif
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
                            <th>No.Seri</th>
                            @if(auth()->user()->role !== 'staf_spi')
                            <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alatmeters as $alatmeter)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $alatmeter->nama_merk }}</td>
                            <td>{{ $alatmeter->no_seri ?? 'Tidak Ada Deskripsi dari Merk Meter Ini' }}</td>
                            @if(auth()->user()->role !== 'staf_spi')
                            <td>
                                <!-- Update Button -->
                                <a href="{{ route('alatmeter.edit', $alatmeter->id) }}" class="btn btn-info"><i
                                        class="fas fa-edit"></i></a>
                                <!-- Delete Button -->
                                <form id="delete-form-{{ $alatmeter->id }}" action="{{ route('alatmeter.destroy', $alatmeter->id) }}" method="POST" class="d-inline">
                                    @method('DELETE')
                                    @csrf
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $alatmeter->id }})"><i
                                            class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection
