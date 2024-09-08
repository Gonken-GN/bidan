<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrilldownJenisImunisasi extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'kode_provinsi',
        'nama_provinsi',
        'kode_kabupaten_kota',
        'nama_kabupaten_kota',
        'jumlah_bayi_campak_mr1',
        'jumlah_bayi_campak_mr2',
        'jumlah_bayi_dpt_hb_hib3',
        'jumlah_bayi_dpt_hb_hib_4',
        'jumlah_bayi_polio',
        'jumlah_bayi_bcg',
        'satuan',
        'tahun',
    ];
}
