<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KunjunganBumil extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'kode_provinsi',
        'nama_provinsi',
        'kode_kabupaten_kota',
        'nama_kabupaten_kota',
        'jenis_kunjungan',
        'jumlah_kunjungan_bumil',
        'satuan',
        'tahun',
    ];
}
