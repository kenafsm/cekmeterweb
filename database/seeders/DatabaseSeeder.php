<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\MerkMeter;
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
            PelangganSeeder::class,
            MerkMeterSeeder::class,
            StaffSeeder::class,
        ]);
    }
}
