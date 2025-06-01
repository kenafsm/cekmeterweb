@extends('layout.dashboard-layout')

@section('title','Admin Dashboard - Log Data')

@section('main-content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex flex-wrap justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Log Data (Riwayat Cek) - CekMeter Air PUDAM Banyuwangi</h1>
        @if(auth()->user()->role !== 'staf_spi')
        {{-- <a href="{{ route('logdata.create') }}" class="btn btn-sm btn-primary shadow-sm d-sm-inline-block d-block">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data
        </a> --}}
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
            <!-- Tombol Filter -->
            <div class="d-flex justify-content-end mb-3">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#filterModal">
                    <i class="fas fa-fw fa-filter"></i><span>Filter</span>
                </button>
            </div>
            <!-- Tabel -->
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Staf Lapangan</th>
                            <th>No.SP Pelanggan</th>
                            <th>Nama Pelanggan</th>
                            <th>Alat Meter</th>
                            <th>Kondisi Meter</th>
                            <th>Tahun Instalasi</th>
                            <th>Tahun Kadaluarsa</th>
                            <th>Keterangan Kondisi</th>
                            <th>Foto Meter</th>
                            <th>Tanggal Cek</th>
                            @if(auth()->user()->role !== 'staf_spi')
                            <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logdata as $index => $object)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $object->staflapangan->nama_staff ?? 'Petugas Tidak Ditemukan' }}</td>
                            <td>{{ $object->pelanggan->no_sp ?? 'No. SP Tidak Ditemukan' }}</td>
                            <td>{{ $object->pelanggan->nama_pelanggan ?? 'Tidak Ada Pelanggan Ditemukan' }}</td>
                            <td>{{ $object->merkMeter->nama_merk ?? 'Belum Ada Merk' }}</td>
                            <td>{{ $object->kondisi_meter ?? 'Belum Ada' }}</td>
                            <td>{{ $object->tahun_instalasi ?? 'Belum Ada' }}</td>
                            <td>{{ $object->tahun_kadaluarsa ?? 'Belum Ada' }}</td>
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
                                <!-- View Button -->
                                <a href="{{ route('logdata.show', $object->id)}}" class="btn btn-success mr-1">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(auth()->user()->role !== 'staf_spi')
                                <!-- Update Button -->
                                <a href="{{ route('logdata.edit', $object->id)}}" class="btn btn-info mr-1">
                                    <i class="fas fa-edit"></i>
                                </a>
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

<!-- Modal Filter Rentang Tanggal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Berdasarkan Rentang Tanggal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('logdata.index') }}" method="GET">
                    <div class="form-group">
                        <label for="start_date">Tanggal Mulai:</label>
                        <input type="date" id="start_date" name="start_date" class="form-control"
                            value="{{ $startDate }}">
                    </div>
                    <div class="form-group">
                        <label for="end_date">Tanggal Akhir:</label>
                        <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $endDate }}">
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Terapkan</button>
                        <a href="{{ route('logdata.index') }}" class="btn btn-danger ml-2">Reset</a>
                        <button type="button" class="btn btn-secondary ml-2" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
