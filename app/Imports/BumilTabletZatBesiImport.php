<?php

namespace App\Imports;

use App\Models\BumilTabletZatBesi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BumilTabletZatBesiImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new BumilTabletZatBesi([
            'id' => $row['id'],
            'kode_provinsi' => $row['kode_provinsi'],
            'nama_provinsi' => $row['nama_provinsi'],
            'kode_kabupaten_kota' => $row['kode_kabupaten_kota'],
            'nama_kabupaten_kota' => $row['nama_kabupaten_kota'],
            'jenis_tablet' => $row['jenis_tablet'],
            'jumlah_bumil' => $row['jumlah_bumil'],
            'satuan' => $row['satuan'],
            'tahun' => $row['tahun'],
        ]);
    }
}
