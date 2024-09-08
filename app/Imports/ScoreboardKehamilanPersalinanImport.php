<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\ScoreboardKehamilanPersalinan;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ScoreboardKehamilanPersalinanImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ScoreboardKehamilanPersalinan([
            'id' => $row['id'],
            'kode_provinsi' => $row['kode_provinsi'],
            'nama_provinsi' => $row['nama_provinsi'],
            'kode_kabupaten_kota' => $row['kode_kabupaten_kota'],
            'nama_kabupaten_kota' => $row['nama_kabupaten_kota'],
            'jumlah_penerima_ttd' => $row['jumlah_penerima_ttd'],
            'jumlah_perkiraan_komplikasi_bidan' => $row['jumlah_perkiraan_komplikasi_bidan'],
            'jumlah_kematian' => $row['jumlah_kematian'],
            'jumlah_resti' => $row['jumlah_resti'],
            'satuan' => $row['satuan'],
            'tahun' => $row['tahun'],
        ]);
    }
}
