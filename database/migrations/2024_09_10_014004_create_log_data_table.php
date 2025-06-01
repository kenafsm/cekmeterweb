<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('log_data', function (Blueprint $table) {
            $table->id();
            $table->string('staf_nip');
            $table->string('no_sp');
            $table->string('alat_meter_id');
            $table->string('foto_meter')->nullable();
            $table->string('kondisi_meter')->nullable();
            $table->string('ket_kondisi')->nullable();
            $table->string('tahun_instalasi');
            $table->string('tahun_kadaluarsa');
            $table->datetime('tanggal_cek');
            $table->timestamps();
            $table->foreign('staf_nip')->references('nip')->on('staflapangan');
            $table->foreign('no_sp')->references('no_sp')->on('pelanggans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_data');
    }
};
