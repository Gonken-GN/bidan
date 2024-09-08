<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IbuBersalin extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'kode_provinsi',
        'nama_provinsi',
        'kode_kabupaten_kota',
        'nama_kabupaten_kota',
        'jumlah_ibu_bersalin',
        'jumlah_ibu_hamil',
        'satuan',
        'tahun',
    ];
}
