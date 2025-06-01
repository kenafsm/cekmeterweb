<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staffs';

    protected $fillable = [
        'nip',
        'nama_staff',
        'no_telepon',
        'wilayah',
        'password'
    ];
    protected $hidden = [
        'password',
    ];

    public function logData()
    {
        return $this->hasMany(LogData::class, 'petugas_id');
    }
}
