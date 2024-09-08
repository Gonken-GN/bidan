<?php

namespace App\Http\Controllers;

use App\Imports\KbLengkapImport;
use App\Models\KbLengkap;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class KbLengkapController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan data dari request, misalnya tanggal awal dan akhir
        $year = $request->input('year');
        $kabkota = $request->input('kabkota');

        // Get the list of years
        $years = KbLengkap::selectRaw('tahun')->distinct()->pluck('tahun');

        // Get the list of cities
        $cities = KbLengkap::select('nama_kabupaten_kota')->distinct()->get()->pluck('nama_kabupaten_kota');

        // Filter data by year range and kabkota
        $datakb = KbLengkap::where('tahun', $year)
            ->where('nama_kabupaten_kota', $kabkota)
            ->get();
        
        // Hitung data untuk ditampilkan pada scoreboard


        // Data untuk chart utama
        $totalKb = $datakb->groupBy('metode_kb')->map(function ($items, $metode) {
            $jumlah = $items->sum('jumlah_peserta');
            $jenisKb = $items->groupBy('jenis_kb')->map(function ($jenisItems, $jenis) {
                return [
                    'name' => $jenis,
                    'y' => $jenisItems->sum('jumlah_peserta')
                ];
            })->values();
        
            return [
                'jumlah' => $jumlah,
                'jenis_kb' => $jenisKb, // Store the detailed data here
                'metode' => $metode
            ];
        })->values();

        // Find the most common metode KB
        $mostCommonMetodeKb = $totalKb->sortByDesc('jumlah')->first();

        // Find the most common jenis KB
        $mostCommonJenisKb = $totalKb->flatMap(function ($item) {
            return $item['jenis_kb'];  // Extract jenis_kb array
        })->sortByDesc('y')->first()['name'] ?? null;

        

        // Calculate total number of participants
        $totalParticipants = $totalKb->sum('jumlah');
        

        return view('pelayanan.KbLengkap', [
            'dataAkseptor' => $datakb,
            'year' => $year,
            'cities' => $cities,
            'totalKb' => $totalKb,
            'mostCommonMetodeKb' => $mostCommonMetodeKb,
            'mostCommonJenisKb' => $mostCommonJenisKb,
            'totalParticipants' => $totalParticipants,
            'years' => $years,
            'kabkota' => $kabkota
        ]);
    }
    public function importFromFile()
    {
        // Tentukan path ke file Excel yang ingin diimpor
        $filePath = public_path('dataset/dinkes-od_15957_jml_peserta_keluarga_berencana_kb_aktif__metode_kb_v3_data.xlsx');

        // Impor data
        Excel::import(new KbLengkapImport, $filePath);

        return back()->with('success', 'Data berhasil diimport dari file Excel.');
    }
}
