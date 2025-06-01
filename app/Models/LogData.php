<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogData extends Model
{
    use HasFactory;

    protected $table = 'log_data';

    protected $fillable = [
        'petugas_id',
        'pelanggan_id',
        'merk_meter_id',
        'foto_meter',
        'kondisi_meter',
        'ket_kondisi',
        'tanggal_cek'
    ];

    protected $hidden = [];

    public function petugas()
    {
        return $this->belongsTo(Staff::class, 'petugas_id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function merkMeter()
    {
        return $this->belongsTo(MerkMeter::class, 'merk_meter_id');
    }

}
