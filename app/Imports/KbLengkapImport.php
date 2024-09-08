<?php

namespace App\Imports;

use App\Models\KbLengkap;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KbLengkapImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new KbLengkap([
            'id' => $row['id'],
            'kode_provinsi' => $row['kode_provinsi'],
            'nama_provinsi' => $row['nama_provinsi'],
            'kode_kabupaten_kota' => $row['kode_kabupaten_kota'],
            'nama_kabupaten_kota' => $row['nama_kabupaten_kota'],
            'metode_kb' => $row['metode_kb'],
            'jenis_kb' => $row['jenis_kb'],
            'jumlah_peserta' => $row['jumlah_peserta'],
            'satuan' => $row['satuan'],
            'tahun' => $row['tahun'],
        ]);
    }
}
