<?php

namespace Database\Seeders;

use App\Models\Wilayah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahSeeder extends Seeder {
    public function run(): void
    {
        Wilayah::create([
            'kode_wilayah' => '01',
            'nama_wilayah' => 'Banyuwangi',
        ]);
        Wilayah::create([
            'kode_wilayah' => '02',
            'nama_wilayah' => 'Rogojampi',
        ]);
        Wilayah::create([
            'kode_wilayah' => '03',
            'nama_wilayah' => 'Muncar',
        ]);
        Wilayah::create([
            'kode_wilayah' => '04',
            'nama_wilayah' => 'Genteng',
        ]);
        Wilayah::create([
            'kode_wilayah' => '05',
            'nama_wilayah' => 'Wongsorejo',
        ]);
        Wilayah::create([
            'kode_wilayah' => '06',
            'nama_wilayah' => 'Tegaldlimo',
        ]);
        
    }
}
