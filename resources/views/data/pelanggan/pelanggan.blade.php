@extends('layout.dashboard-layout')

@section('title','Admin Dashboard - Data Pelanggan')

@section('main-content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex flex-wrap justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Pelanggan - CekMeter Air PUDAM Banyuwangi</h1>
        @if(auth()->user()->role !== 'staf_spi')
        <a href="{{ route('pelanggan.create') }}" class="btn btn-sm btn-primary shadow-sm d-sm-inline-block d-block"><i
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
                            <th>Nomor SP</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Tahun Instalasi</th>
                            <th>Tahun Kadaluarsa</th>
                            <th>Alamat</th>
                            <th>Nama Staf</th>
                            <th>Wilayah</th>
                            @if(auth()->user()->role !== 'staf_spi')
                            <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pelanggan as $index => $object)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $object ->no_sp }}</td>
                            <td>{{ $object ->nama_pelanggan }}</td>
                            <td>{{ $object ->status }}</td>
                            <td>{{ $object ->tahun_instalasi }}</td>
                            <td>{{ $object ->tahun_kadaluarsa }}</td>
                            <td>{{ $object ->alamat }}</td>
                            <td>{{ $object->staflapangan->nama_staff ?? 'Petugas Tidak Ditemukan' }}</td>
                            <td>{{ $object ->wilayah->nama_wilayah }}</td>
                            @if(auth()->user()->role !== 'staf_spi')
                            <td>
                                <!-- Update Button -->
                                <a href="{{ route('pelanggan.edit', $object->no_sp)}}" class="btn btn-info"><i
                                        class="fas fa-edit"></i></a>
                                <!-- Delete Button -->
                                <form id="delete-form-{{ $object->no_sp }}"
                                    action="{{ route('pelanggan.destroy', $object->no_sp) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <!-- Perbaikan tombol delete -->
                                    <button type="button" class="btn btn-danger"
                                        onclick="confirmDelete('{{ $object->no_sp }}')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                            @endif
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
