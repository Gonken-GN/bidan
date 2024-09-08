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
        Schema::create('drilldown_jenis_imunisasis', function (Blueprint $table) {
            $table->id();
            $table->integer('kode_provinsi');
            $table->string('nama_provinsi');
            $table->integer('kode_kabupaten_kota');
            $table->string('nama_kabupaten_kota');
            $table->integer('jumlah_bayi_campak_mr1');
            $table->integer('jumlah_bayi_campak_mr2');
            $table->integer('jumlah_bayi_dpt_hb_hib3');
            $table->integer('jumlah_bayi_dpt_hb_hib_4');
            $table->integer('jumlah_bayi_polio');
            $table->integer('jumlah_bayi_bcg');
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
        Schema::dropIfExists('drilldown_jenis_imunisasis');
    }
};
