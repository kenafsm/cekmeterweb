<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggans';

    protected $fillable = [
        'no_sp',
        'nama_pelanggan',
        'alamat',
        'wilayah_id'
    ];

    protected $hidden = [];

    // RElasi dengan Log Data
    public function logData()
    {
        return $this->hasMany(LogData::class, 'pelanggan_id');
    }

    // Definisikan relasi dengan Wilayah
    public function wilayah() {
        return $this->belongsTo(Wilayah::class, 'wilayah_id', 'id');
    }

}
