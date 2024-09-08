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
        Schema::create('scoreboard_kehamilan_persalinans', function (Blueprint $table) {
            $table->id();
            $table->integer('kode_provinsi');
            $table->string('nama_provinsi');
            $table->integer('kode_kabupaten_kota');
            $table->string('nama_kabupaten_kota');
            $table->integer('jumlah_penerima_ttd');
            $table->integer('jumlah_perkiraan_komplikasi_bidan');
            $table->integer('jumlah_kematian');
            $table->integer('jumlah_resti');
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
        Schema::dropIfExists('scoreboard_kehamilan_persalinans');
    }
};
