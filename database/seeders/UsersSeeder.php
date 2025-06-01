<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Staf SPI',
            'email' => 'staf.spi@gmail.com',
            'password' => Hash::make('stafspi123'),
            'role' => 'staf_spi',
        ]);

        User::create([
            'name' => 'Staf Lapangan',
            'email' => '1234567890', // example nip as email
            'password' => Hash::make('staflapangan123'),
            'role' => 'staf_lapangan',
        ]);
    }
}
