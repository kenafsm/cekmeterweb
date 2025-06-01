<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatMeter extends Model
{
    use HasFactory;
    protected $table = 'alatmeters';

    protected $fillable = ['nama_merk', 'no_seri'];

    protected $hidden = [];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function logData()
    {
        return $this->hasMany(LogData::class, 'alat_meter_id');
    }
}
