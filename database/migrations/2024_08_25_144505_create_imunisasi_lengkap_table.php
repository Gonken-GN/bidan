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
        Schema::create('imunisasi_lengkap', function (Blueprint $table) {
            $table->id();
            $table->integer('kode_provinsi');
            $table->string('nama_provinsi');
            $table->integer('kode_kabupaten_kota');
            $table->string('nama_kabupaten_kota');
            $table->string('jenis_kelamin');
            $table->integer('jumlah_bayi');
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
        Schema::dropIfExists('imunisasi_lengkap');
    }
};
