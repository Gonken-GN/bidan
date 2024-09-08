<?php

namespace App\Imports;

use App\Models\JenisImunisasi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JenisImunisasiImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new JenisImunisasi([
            'id' => $row['id'],
            'kode_provinsi' => $row['kode_provinsi'],
            'nama_provinsi' => $row['nama_provinsi'],
            'kode_kabupaten_kota' => $row['kode_kabupaten_kota'],
            'nama_kabupaten_kota' => $row['nama_kabupaten_kota'],
            'jumlah_bayi_hepatitis' => $row['jumlah_bayi_hepatitis'],
            'jumlah_bayi_campak' => $row['jumlah_bayi_campak'],
            'jumlah_bayi_polio' => $row['jumlah_bayi_polio'],
            'jumlah_bayi_bcg' => $row['jumlah_bayi_bcg'],
            'satuan' => $row['satuan'],
            'tahun' => $row['tahun'],
        ]);
    }
}
