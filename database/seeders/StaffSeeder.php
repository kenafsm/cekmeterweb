<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Staff::create([
            'nip' => '1234567890',
            'nama_staff' => 'Rio Adjie',
            'no_telepon' => '081234567890',
            'wilayah' => '01 - Banyuwangi',
            'password' => 'password',
        ]);
    }
}
