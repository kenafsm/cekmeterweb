<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerkMeter extends Model
{
    use HasFactory;
    protected $table = 'merk_meters';

    protected $fillable = ['nama_merk', 'deskripsi'];

    protected $hidden = [];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function logData()
    {
        return $this->hasMany(LogData::class, 'merk_meter_id');
    }
}
