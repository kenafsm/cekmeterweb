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
        Schema::create('staflapangan', function (Blueprint $table) {            
            $table->string('nip', 25)->primary();
            $table->string('nama_staff', 50);
            $table->string('status', 15);
            $table->string('no_telepon', 25);
            $table->string('jumlah_cek', 25);
            $table->string('target_cek', 25);
            $table->string('kode_wilayah');  // Foreign key ke tabel wilayah
            $table->string('password', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staflapangan');
    }
};
