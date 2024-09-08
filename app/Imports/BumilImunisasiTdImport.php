<?php

namespace App\Imports;

use App\Models\BumilImunisasiTd;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BumilImunisasiTdImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new BumilImunisasiTd([
            'id' => $row['id'],
            'kode_provinsi' => $row['kode_provinsi'],
            'nama_provinsi' => $row['nama_provinsi'],
            'kode_kabupaten_kota' => $row['kode_kabupaten_kota'],
            'nama_kabupaten_kota' => $row['nama_kabupaten_kota'],
            'jenis_imunisasi' => $row['jenis_imunisasi'],
            'jumlah_penerima' => $row['jumlah_penerima'],
            'satuan' => $row['satuan'],
            'tahun' => $row['tahun'],
        ]);
    }
}
