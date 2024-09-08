<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisImunisasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'kode_provinsi',
        'nama_provinsi',
        'kode_kabupaten_kota',
        'nama_kabupaten_kota',
        'jumlah_bayi_hepatitis',
        'jumlah_bayi_campak',
        'jumlah_bayi_polio',
        'jumlah_bayi_bcg',
        'satuan',
        'tahun',
    ];
}
