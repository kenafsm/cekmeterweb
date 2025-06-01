<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->string('no_sp', 10)->primary();
            $table->string('nama_pelanggan', 255);
            $table->text('alamat');
            $table->string('staf_nip', 25);  // Changed to match staflapangan.nip length
            $table->string('status', 50);
            $table->string('kode_wilayah', 2);
            $table->string('tahun_instalasi', 4);
            $table->string('tahun_kadaluarsa', 4);
            $table->timestamps();

            $table->foreign('kode_wilayah')
                  ->references('kode_wilayah')
                  ->on('wilayahs');
                  
            $table->foreign('staf_nip')
                  ->references('nip')
                  ->on('staflapangan');  // Corrected table name
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelanggans');
    }
};
