<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;

    protected $table = 'wilayahs';  // Changed from 'wilayah' to match migration

    protected $primaryKey = 'kode_wilayah';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['kode_wilayah', 'nama_wilayah'];

    public function pelanggan() {
        return $this->hasMany(Pelanggan::class, 'kode_wilayah', 'kode_wilayah');
    }

    public function staff() {
        return $this->hasMany(StafLapangan::class, 'kode_wilayah', 'kode_wilayah');
    }
}
