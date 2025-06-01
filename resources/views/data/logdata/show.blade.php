@extends('layout.dashboard-layout')

@section('title','Admin Dashboard - Detail Log Data')

@section('main-content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Detail Log Data</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">No SP:</dt>
                        <dd class="col-sm-8">{{ $logdata->no_sp }}</dd>

                        <dt class="col-sm-4">Alat Meter:</dt>
                        <dd class="col-sm-8">{{ $logdata->alat_meter_id }}</dd>

                        <dt class="col-sm-4">Kondisi Meter:</dt>
                        <dd class="col-sm-8">{{ $logdata->kondisi_meter }}</dd>

                        <dt class="col-sm-4">Tahun Instalasi:</dt>
                        <dd class="col-sm-8">{{ $logdata->tahun_instalasi }}</dd>

                        <dt class="col-sm-4">Tahun Kadaluarsa:</dt>
                        <dd class="col-sm-8">{{ $logdata->tahun_kadaluarsa }}</dd>

                        <dt class="col-sm-4">Tanggal Cek:</dt>
                        <dd class="col-sm-8">{{ $logdata->tanggal_cek }}</dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <div class="text-center">
                        <h5>Foto Meter</h5>
                        <img src="{{ asset('storage/'.$logdata->foto_meter) }}" 
                             class="img-fluid" 
                             alt="Foto Meter" 
                             style="max-height: 500px;">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('logdata.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
