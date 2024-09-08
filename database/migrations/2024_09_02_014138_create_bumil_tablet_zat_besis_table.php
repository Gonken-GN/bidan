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
        Schema::create('bumil_tablet_zat_besis', function (Blueprint $table) {
            $table->id();
            $table->integer('kode_provinsi');
            $table->string('nama_provinsi');
            $table->integer('kode_kabupaten_kota');
            $table->string('nama_kabupaten_kota');
            $table->string('jenis_tablet');
            $table->integer('jumlah_bumil');
            $table->string('satuan');
            $table->integer('tahun');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bumil_tablet_zat_besis');
    }
};
