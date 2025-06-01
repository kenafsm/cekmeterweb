@extends('layout.dashboard-layout')

@section('title','Admin Dashboard - Rekap Staf')

@section('main-content')

{{-- Tabel Data User --}}
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Rekapitulasi Data Kerja Staf Lapangan</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width:"100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Wilayah</th>
                            <th scope="col">Jumlah Data</th>
                            <th scope="col">Target Data</th>
                            @if(auth()->user()->role !== 'staf_spi')
                            <th scope="col">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($staflapangans as $i => $object)
                        <tr class="text-center">
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $object->nama_staff }}</td>
                            <td>{{ $object->wilayah->nama_wilayah }}</td>
                            <td>{{ $object->jumlah_cek }}</td>
                            <td>{{ $object->target_cek }}</td>
                            @if(auth()->user()->role !== 'staf_spi')
                            <td>
                                <!-- Update Button -->
                                <a href="{{ route('staflapangan.detailrekap', $object->nip)}}" class="btn btn-info"><i
                                        class="fas fa-edit"></i></a>
                                <!-- Delete Button -->
                                <form id="delete-form-{{ $object->nip }}" action="{{route('staflapangan.destroy', $object->nip)}}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger" onclick="confirmDeleteStaff({{ $object->nip }})">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
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
