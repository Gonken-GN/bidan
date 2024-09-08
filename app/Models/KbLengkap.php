<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KbLengkap extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'kode_provinsi',
        'nama_provinsi',
        'kode_kabupaten_kota',
        'nama_kabupaten_kota',
        'metode_kb',
        'jenis_kb',
        'jumlah_peserta',
        'satuan',
        'tahun',
    ];
}
