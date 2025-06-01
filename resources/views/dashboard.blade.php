@extends('layout.dashboard-layout')

@section('title','Admin Dashboard - CekMeter PUDAM')

@section('main-content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex flex-wrap justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Admin - CekMeter Air PUDAM Banyuwangi</h1>
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif
        {{-- <a href="#" class="btn btn-sm btn-primary shadow-sm d-sm-inline-block d-block"><i
                class="fas fa-download fa-sm text-white-50"></i> Ekspor Data</a> --}}
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Log Data Card  -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Data Pengecekan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $logdataCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fw fa-database text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Pelanggan Card  -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Pelanggan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pelangganCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Merk Meter Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Merk Meter Air PUDAM</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $merkmeterCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tachometer-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Staff/User Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Staf Lapangan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $staffCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Tabel Review 10 Cek Meter Air -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Rekap Cek Alat Meter Air</h6>
                    <!-- Group Tombol Filter dan Dropdown -->
                    <div class="d-flex align-items-center">
                        <!-- Tombol Filter -->
                        <button type="button" class="btn btn-primary btn-sm mr-2" data-toggle="modal"
                            data-target="#filterModal">
                            <i class="fas fa-fw fa-filter"></i> <span>Filter</span>
                        </button>
                        <!-- Dropdown -->
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Lebih Banyak:</div>
                                <a class="dropdown-item" href="{{ route('logdata.index') }}">Riwayat Lengkap</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!-- Tabel -->
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead class="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Petugas</th>
                                    <th>No. SP Pelanggan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Merk Meter</th>
                                    <th>Tanggal Cek</th>
                                    <th>Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logdata as $index => $object)
                                <tr class="text-center">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $object->stafLapangan->nama_staff ?? 'Petugas Tidak Ditemukan' }}</td>
                                    <td>{{ $object->pelanggan->no_sp ?? 'No. SP Tidak Ditemukan' }}</td>
                                    <td>{{ $object->pelanggan->nama_pelanggan ?? 'Tidak Ada Pelanggan Ditemukan' }}</td>
                                    <td>{{ $object->alatMeter->nama_merk ?? 'Belum Ada Merk' }}</td>
                                    <td>{{ $object->tanggal_cek ?? 'Belum Dicek' }}</td>
                                    <td>{{ $object->kondisi_meter ?? 'Belum Dicek' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Perbaikan Alat Meter Air</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Lebih Banyak:</div>
                            <a class="dropdown-item" href="#">Lebih</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Pie Chart --}}
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
                <form action="{{ route('dashboard.index') }}" method="GET">
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
                        <a href="{{ route('dashboard.index') }}" class="btn btn-danger ml-2">Reset</a>
                        <button type="button" class="btn btn-secondary ml-2" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan Script Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Ambil data dari controller
    const logDataCount = @json($logdataCount);
    const pelangganCount = @json($pelangganCount);

    // Pie Chart for Meter Conditions
    const ctx = document.getElementById('myPieChart').getContext('2d');
    const myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Baik', 'Rusak'],
            datasets: [{
                data: [@json($baikCount), @json($rusakCount)],
                backgroundColor: ['#4e73df', '#e74a3b'],
                hoverBackgroundColor: ['#2e59d9', '#d62c1a'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.formattedValue || '';
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let percentage = Math.round((context.raw / total) * 100);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        },
    });
</script>

@endsection
