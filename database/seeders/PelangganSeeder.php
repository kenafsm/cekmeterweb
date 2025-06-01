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
            'alamat' => ('Giri, Banyuwangi, Jawa Timur'),
            'wilayah_id' => ('1')
        ]);
    }
}
