<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pelanggan::create([
            'no_sp' => '01223344',
            'nama_pelanggan' => 'Ken Affila',
            'status' => 'Aktif',
            'tahun_instalasi' => '2020',
            'tahun_kadaluarsa' => '2025',
            'alamat' => ('Giri, Banyuwangi, Jawa Timur'),
            'staf_nip' => '1234567890',
            'kode_wilayah' => ('01')
        ]);
    }
}
