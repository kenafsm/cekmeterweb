@extends('layout.dashboard-layout')

@section('title','Admin Dashboard - Detail Rekap Staf')

@section('main-content')

{{-- Tabel Data User --}}
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Rekapitulasi Data Kerja Staf Lapangan</h1>
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
                            <th>No</th>
                            <th>No.SP</th>
                            <th>Nama Pelanggan</th>
                            <th>Alamat</th>
                            <th>Merk Meter</th>
                            <th>Tanggal Cek</th>
                            <th>Kondisi</th>

                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($logdata as $i => $log)
                        <tr class="text-center">
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $log->pelanggan->no_sp ?? '-' }}</td>
                            <td>{{ $log->pelanggan->nama_pelanggan ?? '-' }}</td>
                            <td>{{ $log->pelanggan->alamat ?? '-' }}</td>
                            <td>{{ $log->alatMeter->nama_merk ?? '-' }}</td>
                            <td>{{ $log->tanggal_cek->format('d-m-Y') }}</td>
                            <td>{{ $log->kondisi_meter }}</td>

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
