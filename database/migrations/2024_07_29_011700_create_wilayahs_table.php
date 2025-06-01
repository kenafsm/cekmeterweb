<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wilayahs', function (Blueprint $table) {
            $table->string('kode_wilayah', 2)->primary();
            $table->string('nama_wilayah', 50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wilayahs');
    }
};
