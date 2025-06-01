<?php

namespace Database\Seeders;

use App\Models\MerkMeter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MerkMeterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MerkMeter::create([
            'nama_merk' => 'Sanyo',
            'deskripsi' => 'Baru Install',
        ]);
    }
}
