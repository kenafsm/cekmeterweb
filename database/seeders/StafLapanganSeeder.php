<?php

namespace Database\Seeders;

use App\Models\StafLapangan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class StafLapanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StafLapangan::create([
            'nip' => '1234567890',
            'nama_staff' => 'Rio Adjie',
            'status' => 'Aktif',
            'no_telepon' => '081234567890',
            'jumlah_cek' => '23',
            'target_cek' => '39',
            'kode_wilayah' => '01',
            'password' => 'password',
        ]);
    }
}
