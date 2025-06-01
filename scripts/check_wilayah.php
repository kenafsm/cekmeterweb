<?php

use App\Models\Wilayah;

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

$kodeWilayah = '01';

$wilayah = Wilayah::where('kode_wilayah', $kodeWilayah)->first();

if ($wilayah) {
    echo "Wilayah ditemukan: " . $wilayah->nama_wilayah . " (kode: " . $wilayah->kode_wilayah . ")\n";
} else {
    echo "Wilayah dengan kode_wilayah '$kodeWilayah' tidak ditemukan.\n";
}
