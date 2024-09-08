<?php

namespace App\Http\Controllers;

use App\Imports\ScoreboardKehamilanPersalinanImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ScoreboardKehamilanPersalinanController extends Controller
{
    public function importFromFile()
    {
        // Tentukan path ke file Excel yang ingin diimpor
        $filePath = public_path('dataset/scoreboard_layanan_kehamilan_dan_persalinan.xlsx');

        // Impor data
        Excel::import(new ScoreboardKehamilanPersalinanImport, $filePath);

        return back()->with('success', 'Data berhasil diimport dari file Excel.');
    }
}
