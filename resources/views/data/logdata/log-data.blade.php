@extends('layout.dashboard-layout')

@section('title','Admin Dashboard - Log Data')

@section('main-content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Log Data Cek Meter PUDAM Banyuwangi</h1>
        <a href="{{ route('logdata.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
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
                            <th>ID Petugas</th>
                            <th>No. SP Pelanggan</th>
                            <th>Nama Pelanggan</th>
                            <th>Merk Meter</th>
                            <th>Kondisi Meter</th>
                            <th>Keterangan Kondisi</th>
                            <th>Foto Meter</th>
                            <th>Tanggal Cek</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logdata as $index => $object)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $object->petugas->nip ?? 'NIP Tidak Ditemukan' }}</td>
                            <td>{{ $object->pelanggan->no_sp ?? 'No. SP Tidak Ditemukan' }}</td>
                            <td>{{ $object->pelanggan->nama_pelanggan ?? 'Tidak Ada Pelanggan Ditemukan' }}</td>
                            <td>{{ $object->merkMeter->nama_merk ?? 'Belum Ada Merk' }}</td>
                            <td>{{ $object->kondisi_meter ?? 'Belum Ada' }}</td>
                            <td>{{ $object->ket_kondisi ?? 'Tidak Ada Keterangan' }}</td>
                            <td>
                                @if ($object->foto_meter)
                                <img src="{{ asset('storage/' . $object->foto_meter) }}" alt="Foto Meter"
                                    style="max-width: 50px;">
                                @else
                                Tidak ada foto
                                @endif
                            </td>
                            <td>{{ $object->tanggal_cek ?? 'Belum Dicek' }}</td>
                            <td>
                                <!-- Update Button -->
                                <a href="{{ route('logdata.edit', $object->id)}}" class="btn btn-info"><i
                                        class="fas fa-edit"></i></a>
                                <!-- Delete Button -->
                                <form id="delete-form-{{ $object->id }}"
                                    action="{{route('logdata.destroy', $object->id)}}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <!-- Perbaikan tombol delete -->
                                    <button type="button" class="btn btn-danger"
                                        onclick="confirmDelete({{ $object->id }})">
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
