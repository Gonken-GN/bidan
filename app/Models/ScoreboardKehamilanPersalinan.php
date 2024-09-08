<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreboardKehamilanPersalinan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'kode_provinsi',
        'nama_provinsi',
        'kode_kabupaten_kota',
        'nama_kabupaten_kota',
        'jumlah_penerima_ttd',
        'jumlah_perkiraan_komplikasi_bidan',
        'jumlah_kematian',
        'jumlah_resti',
        'satuan',
        'tahun',
    ];
}
