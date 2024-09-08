<?php

namespace App\Http\Controllers;

use App\Models\IbuBersalin;
use Illuminate\Http\Request;
use App\Imports\IbuBersalinImport;
use Maatwebsite\Excel\Facades\Excel;


class IbuBersalinController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan data dari request, misalnya tanggal awal dan akhir
        $awal = $request->input('awal');
        $akhir = $request->input('akhir');

        $dataAkseptor = IbuBersalin::whereBetween('tahun', [$awal, $akhir])
            ->get();

        // Hitung data untuk ditampilkan pada scoreboard
        $kunjungan = $dataAkseptor->count();
        $ibuHamil = $dataAkseptor->sum('jumlah_ibu_bersalin');
        $rerata = $dataAkseptor->avg($ibuHamil);

        $totalibuHamil = $dataAkseptor->groupBy('tahun')->map(function ($items, $tahun) {
            $jumlah = $items->sum('jumlah_ibu_bersalin');
            return [
                'tahun' => $tahun,
                'jumlah' => $jumlah,
                'bayi_hidup' => ($jumlah * 2)/3,
                'bayi_mati' => ($jumlah * 1)/3
            ];
        })->values();
        

        return view('pelayanan.JumlahIbuBersalin', [
            'dataAkseptor' => $dataAkseptor,
            'awal' => $awal,
            'akhir' => $akhir,
            'kunjungan' => $kunjungan,
            'ibuHamil' => $ibuHamil,
            'rerata' => $rerata,
            'total' => $totalibuHamil
        ]);
    }
    public function importFromFile()
    {
        // Tentukan path ke file Excel yang ingin diimpor
        $filePath = public_path('dataset/dinkes-od_17520_jumlah_ibu_bersalin_berdasarkan_kabupatenkota_v1_data.xlsx');

        // Impor data
        Excel::import(new IbuBersalinImport, $filePath);

        return back()->with('success', 'Data berhasil diimport dari file Excel.');
    }
}
