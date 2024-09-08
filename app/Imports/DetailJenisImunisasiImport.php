<?php

namespace App\Imports;

use App\Models\DrilldownJenisImunisasi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DetailJenisImunisasiImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new DrilldownJenisImunisasi([
            'id' => $row['id'],
            'kode_provinsi' => $row['kode_provinsi'],
            'nama_provinsi' => $row['nama_provinsi'],
            'kode_kabupaten_kota' => $row['kode_kabupaten_kota'],
            'nama_kabupaten_kota' => $row['nama_kabupaten_kota'],
            'jumlah_bayi_campak_mr1' => $row['jumlah_bayi_campak_mr1'],
            'jumlah_bayi_campak_mr2' => $row['jumlah_bayi_campak_mr2'],
            'jumlah_bayi_dpt_hb_hib3' => $row['jumlah_bayi_dpt_hb_hib3'],
            'jumlah_bayi_dpt_hb_hib_4' => $row['jumlah_bayi_dpt_hb_hib_4'],
            'jumlah_bayi_polio' => $row['jumlah_bayi_polio'],
            'jumlah_bayi_bcg' => $row['jumlah_bayi_bcg'],
            'satuan' => $row['satuan'],
            'tahun' => $row['tahun'],
        ]);
    }
}
