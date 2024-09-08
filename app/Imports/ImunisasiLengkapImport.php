<?php

namespace App\Imports;

use App\Models\ImunisasiLengkap;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImunisasiLengkapImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ImunisasiLengkap([
            'id' => $row['id'],
            'kode_provinsi' => $row['kode_provinsi'],
            'nama_provinsi' => $row['nama_provinsi'],
            'kode_kabupaten_kota' => $row['kode_kabupaten_kota'],
            'nama_kabupaten_kota' => $row['nama_kabupaten_kota'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'jumlah_bayi' => $row['jumlah_bayi'],
            'satuan' => $row['satuan'],
            'tahun' => $row['tahun'],
        ]);
    }
}
