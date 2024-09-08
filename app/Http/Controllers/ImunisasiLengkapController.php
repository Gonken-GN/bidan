<?php

namespace App\Http\Controllers;

use App\Models\DrilldownJenisImunisasi;
use Illuminate\Http\Request;
use App\Models\JenisImunisasi;
use App\Models\ImunisasiLengkap;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\JenisImunisasiImport;
use App\Imports\ImunisasiLengkapImport;
use App\Imports\DetailJenisImunisasiImport;

class ImunisasiLengkapController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan data dari request, misalnya tanggal awal dan akhir
        $year = $request->input('year');
        $kabkota = $request->input('kabkota');

        // Get the list of years
        $years = DrilldownJenisImunisasi::selectRaw('tahun')->distinct()->pluck('tahun');

        // Get the list of cities
        $cities = ImunisasiLengkap::select('nama_kabupaten_kota')->distinct()->get()->pluck('nama_kabupaten_kota');

        // Filter data by year range and kabkota
        $dataimunisasi = ImunisasiLengkap::where('tahun', $year)
            ->where('nama_kabupaten_kota', $kabkota)
            ->get();

        $totalbayi = $dataimunisasi->sum('jumlah_bayi');
        // Sum of jumlah_bayi for female and male babies separately
        $databayiperempuan = $dataimunisasi->where('jenis_kelamin', 'PEREMPUAN')->sum('jumlah_bayi');
        $databayilaki = $dataimunisasi->where('jenis_kelamin', 'LAKI-LAKI')->sum('jumlah_bayi');
        $genderData = [
            'female' => $databayiperempuan,
            'male' => $databayilaki
        ];

        $data_imunisasi = JenisImunisasi::where('tahun', $year)->where('nama_kabupaten_kota', $kabkota)->get();
        $hepatitis = $data_imunisasi->sum('jumlah_bayi_hepatitis');
        $campak = $data_imunisasi->sum('jumlah_bayi_campak');
        $polio = $data_imunisasi->sum('jumlah_bayi_polio');
        $bcg = $data_imunisasi->sum('jumlah_bayi_bcg');

        $data_detail = DrilldownJenisImunisasi::where('tahun', $year)->where('nama_kabupaten_kota', $kabkota)->get();
        $campak1 = $data_detail->sum('jumlah_bayi_campak_mr1');
        $campak2 = $data_detail->sum('jumlah_bayi_campak_mr2');
        $hib3 = $data_detail->sum('jumlah_bayi_dpt_hb_hib3');
        $hib4 = $data_detail->sum('jumlah_bayi_dpt_hb_hib_4');

        $y_data =
        [
            'hepatitis' => $hepatitis,
            'campak' => $campak,
            'polio' => $polio,
            'bcg' => $bcg
        ];

        $drilldown =
        [
            'campak' => [
                ['campak1', $campak1],
                ['campak2', $campak2]
            ],
            'hepatitis' => [
                ['hib3', $hib3],
                ['hib4', $hib4]
            ],
            'polio' => [
                ['polio', $polio]
            ],
            'bcg' => [
                ['bcg', $bcg]
            ]
        ];

        $immunizationSums = [
            'Polio' => $polio,
            'BCG' => $bcg,
            'Campak1' => $campak1,
            'Campak2' => $campak2,
            'Hib3' => $hib3,
            'Hib4' => $hib4,
        ];
    
        $mostCommonImmunization = collect($immunizationSums)->sortDesc()->keys()->first();


        return view('pelayanan.ImunisasiLengkap', [
            'year' => $year,
            'totalbayi' => $totalbayi,
            'immunizationSums' => $immunizationSums,
            'hepatitis' => $hepatitis,
            'campak' => $campak,
            'polio' => $polio,
            'bcg' => $bcg,
            'y_data' => $y_data,
            'drilldown' => $drilldown,
            'cities' => $cities,
            'years' => $years,
            'genderData' => $genderData,
            'mostCommonImmunization' => $mostCommonImmunization
        ]);
    }

    public function importFromFile()
    {
        // Tentukan path ke file Excel yang ingin diimpor
        $filePath = public_path('dataset/dinkes-od_17464_jml_bayi_mendapat_imunisasi_dasar_lengkap__jk_v1_data.xlsx');

        // Impor data
        Excel::import(new ImunisasiLengkapImport, $filePath);

        return back()->with('success', 'Data berhasil diimport dari file Excel.');
    }

    public function importFromFileJenis()
    {
        // Tentukan path ke file Excel yang ingin diimpor
        $filePath = public_path('dataset/dinkes-od_18490_jml_bayi_diimunisasi_berdasarkan_jenis_imunisasi_kabu_v1_data.xlsx');

        // Impor data
        Excel::import(new JenisImunisasiImport, $filePath);

        return back()->with('success', 'Data berhasil diimport dari file Excel.');
    }

    public function importFromFileDetailJenis()
    {
        // Tentukan path ke file Excel yang ingin diimpor
        $filePath = public_path('dataset/drilldownjenisimunisasi.xlsx');

        // Impor data
        Excel::import(new DetailJenisImunisasiImport, $filePath);

        return back()->with('success', 'Data berhasil diimport dari file Excel.');
    }
}
