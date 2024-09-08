<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImunisasiLengkap extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'kode_provinsi',
        'nama_provinsi',
        'kode_kabupaten_kota',
        'nama_kabupaten_kota',
        'jenis_kelamin',
        'jumlah_bayi',
        'satuan',
        'tahun',
    ];
}
