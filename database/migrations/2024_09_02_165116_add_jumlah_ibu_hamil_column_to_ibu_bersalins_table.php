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
        Schema::table('ibu_bersalins', function (Blueprint $table) {
            $table->integer('jumlah_ibu_hamil')->nullable()->after('jumlah_ibu_bersalin'); // Menambahkan kolom 'jumlah ibu hamil'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ibu_bersalins', function (Blueprint $table) {
            $table->dropColumn('jumlah_ibu_hamil'); // Menghapus kolom 'age'
        });
    }
};
