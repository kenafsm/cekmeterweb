<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggans';

    // Atur Primary Key ke no_sp
    protected $primaryKey = 'no_sp';
    public $incrementing = false; // Karena no_sp bukan auto-increment
    protected $keyType = 'string'; // Karena no_sp bertipe string

    protected $fillable = [
        'no_sp',
        'nama_pelanggan',
        'alamat',
        'staf_nip',
        'status',
        'kode_wilayah',
        'tahun_instalasi',
        'tahun_kadaluarsa'
    ];


    // Relasi dengan Log Data
    public function logData()
    {
        return $this->hasMany(LogData::class, 'no_sp', 'no_sp');
    }

    public function stafLapangan()
    {
        return $this->belongsTo(StafLapangan::class, 'staf_nip', 'nip');
    }

    // Definisikan relasi dengan Wilayah
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'kode_wilayah', 'kode_wilayah');
    }
}
