<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function getWilayahByKode($kode)
    {
        // Cari wilayah berdasarkan kode wilayah
        $wilayah = Wilayah::where('kode_wilayah', $kode)->first();

        // Kembalikan hasil dalam bentuk JSON
        if ($wilayah) {
            return response()->json(['nama_wilayah' => $wilayah->nama_wilayah]);
        } else {
            return response()->json(['nama_wilayah' => 'Wilayah tidak ditemukan'], 404);
        }
    }
}
