<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AlatMeter;
use App\Models\Staff;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            WilayahSeeder::class,
            UsersSeeder::class,
            StafLapanganSeeder::class,
            PelangganSeeder::class,
            AlatMeterSeeder::class
        ]);
    }
}
