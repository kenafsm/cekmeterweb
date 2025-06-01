<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;

    protected $table = 'wilayah';

    protected $fillable = ['kode_wilayah', 'nama_wilayah'];

    // Relasi dengan Pelanggan
    public function pelanggan() {
        return $this->hasMany(Pelanggan::class, 'wilayah_id', 'id');
    }
}
