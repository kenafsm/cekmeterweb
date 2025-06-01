<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StafLapangan extends Model
{
    use HasFactory;

    protected $table = 'staflapangan';

    // Atur Primary Key ke nip
    protected $primaryKey = 'nip';
    public $incrementing = false; // Karena no_sp bukan auto-increment
    protected $keyType = 'string'; // Karena no_sp bertipe string

    protected $fillable = [
        'nip',
        'nama_staff',
        'status',
        'no_telepon',
        'jumlah_cek',
        'target_cek',
        'kode_wilayah',
        'password'
    ];

    protected $hidden = [
        'password',
    ];

    public function logData()
    {
        return $this->belongsTo(LogData::class, 'staf_id', 'nip');
    }

    // Definisikan relasi dengan Wilayah
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'kode_wilayah', 'kode_wilayah');
    }
}
