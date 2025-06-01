<?php

namespace Database\Seeders;

use App\Models\AlatMeter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlatMeterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AlatMeter::create([
            'nama_merk' => 'Sanyo',
            'no_seri' => '232322323'
        ]);
    }
}
