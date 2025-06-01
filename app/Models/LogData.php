<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogData extends Model
{
    use HasFactory;

    protected $table = 'log_data';

    protected $fillable = [
        'staf_nip',
        'no_sp',
        'alat_meter_id',
        'foto_meter',
        'kondisi_meter',
        'tahun_instalasi', 
        'tahun_kadaluarsa',
        'ket_kondisi',
        'tanggal_cek'
    ];

    protected $hidden = [];

    protected $casts = [
        'tanggal_cek' => 'datetime',
        'alat_meter_id' => 'string',
        'staf_nip' => 'string',
        'no_sp' => 'string'
    ];


    protected $appends = ['foto_url'];

    protected function serializeDate($date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getFotoUrlAttribute()
    {
        return $this->foto_meter ? asset('storage/'.$this->foto_meter) : null;
    }

    // Relasi ke tabel staff menggunakan 'nip'
    public function stafLapangan()
    {
        return $this->belongsTo(StafLapangan::class, 'staf_nip', 'nip'); // petugas_id dikaitkan dengan nip
    }

    // Relasi ke tabel pelanggans menggunakan 'no_sp'
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'no_sp', 'no_sp'); // Langsung gunakan no_sp
    }

    public function alatMeter()
    {
        return $this->belongsTo(AlatMeter::class, 'alat_meter_id');
    }
}
