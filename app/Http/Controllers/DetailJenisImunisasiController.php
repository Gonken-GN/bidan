<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DetailJenisImunisasiImport;

class DetailJenisImunisasiController extends Controller
{
    public function importFromFile()
    {
        // Tentukan path ke file Excel yang ingin diimpor
        $filePath = public_path('dataset/drilldownjenisimunisasi.xlsx');

        // Impor data
        Excel::import(new DetailJenisImunisasiImport, $filePath);

        return back()->with('success', 'Data berhasil diimport dari file Excel.');
    }
}
