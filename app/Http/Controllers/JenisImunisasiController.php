<?php

namespace App\Http\Controllers;

use App\Imports\JenisImunisasiImport;
use App\Models\JenisImunisasi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class JenisImunisasiController extends Controller
{
    public function index(Request $request)
    {
        $awal = $request->input('awal');
        $akhir = $request->input('akhir');

        $data_imunisasi = JenisImunisasi::whereBetween('tahun', [$awal, $akhir])->get();
        $hepatitis = $data_imunisasi->sum('jumlah_bayi_hepatitis');
        $campak = $data_imunisasi->sum('jumlah_bayi_campak');
        $polio = $data_imunisasi->sum('jumlah_bayi_polio');
        $bcg = $data_imunisasi->sum('jumlah_bayi_bcg');

        return view('imunisasi', [
            'awal' => $awal,
            'akhir' => $akhir,
            'hepatitis' => $hepatitis,
            'campak' => $campak,
            'polio' => $polio,
            'bcg' => $bcg
        ]);
    }

    public function importFromFile()
    {
        // Tentukan path ke file Excel yang ingin diimpor
        $filePath = public_path('dataset/dinkes-od_18490_jml_bayi_diimunisasi_berdasarkan_jenis_imunisasi_kabu_v1_data.xlsx');

        // Impor data
        Excel::import(new JenisImunisasiImport, $filePath);

        return back()->with('success', 'Data berhasil diimport dari file Excel.');
    }
}
