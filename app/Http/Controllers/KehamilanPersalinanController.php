<?php

namespace App\Http\Controllers;

use App\Imports\BumilImunisasiTdImport;
use App\Imports\BumilLahiranImport;
use App\Imports\BumilTabletZatBesiImport;
use App\Imports\KunjunganBumilImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ScoreboardKehamilanPersalinanImport;
use App\Models\BumilImunisasiTd;
use App\Models\BumilLahiran;
use App\Models\BumilTabletZatBesi;
use App\Models\KunjunganBumil;
use App\Models\ScoreboardKehamilanPersalinan;

class KehamilanPersalinanController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan data dari request, misalnya tanggal awal dan akhir
        $year = $request->input('year');
        $kabkota = $request->input('kabkota');

        // Get the list of years
        $years = BumilImunisasiTd::selectRaw('tahun')->distinct()->pluck('tahun');

        // Get the list of cities
        $cities = BumilImunisasiTd::select('nama_kabupaten_kota')->distinct()->get()->pluck('nama_kabupaten_kota');

        // Filter data by year range and kabkota
        $dataScoreboard = ScoreboardKehamilanPersalinan::where('tahun', $year)
            ->where('nama_kabupaten_kota', $kabkota)
            ->get();
        
        // Hitung data untuk ditampilkan pada scoreboard
        $resti = $dataScoreboard->sum('jumlah_resti');
        $komplikasi = $dataScoreboard->sum('jumlah_perkiraan_komplikasi_bidan');
        $ttd = $dataScoreboard->sum('jumlah_penerima_ttd');
        $kematian = $dataScoreboard->sum('jumlah_kematian');

        $scoreboard = [
            'resti' => $resti,
            'komplikasi' => $komplikasi,
            'ttd' => $ttd,
            'kematian' => $kematian
        ];
        // Data untuk chart 1 - Kunjungan Bumil
        $dataKunjunganBumil = KunjunganBumil::where('tahun', $year)
            ->where('nama_kabupaten_kota', $kabkota)
            ->get();

        $kunjunganBumil = $dataKunjunganBumil->groupBy('jenis_kunjungan')->map(function ($items, $jenis) {
            $jumlah = $items->sum('jumlah_kunjungan_bumil');
            return [
                'jenis' => $jenis,
                'jumlah' => $jumlah
            ];
        })->values();

        // Data untuk chart 2 - Imunisasi Bumil
        $dataImunisasiBumil = BumilImunisasiTd::where('tahun', $year)
            ->where('nama_kabupaten_kota', $kabkota)
            ->get();

        $imunisasiBumil = $dataImunisasiBumil->groupBy('jenis_imunisasi')->map(function ($items, $jenis) {
            $jumlah = $items->sum('jumlah_penerima');
            return [
                'jenis' => $jenis,
                'jumlah' => $jumlah
            ];
        })->values();

        // Data untuk chart 3 - Tablet Bumil
        $dataTabletBumil = BumilTabletZatBesi::where('tahun', $year)
            ->where('nama_kabupaten_kota', $kabkota)
            ->get();

        $tabletBumil = $dataTabletBumil->groupBy('jenis_tablet')->map(function ($items, $jenis) {
            $jumlah = $items->sum('jumlah_bumil');
            return [
                'jenis' => $jenis,
                'jumlah' => $jumlah
            ];
        })->values();

        // Data untuk chart 4 - Persalinan Bumil
        $dataPersalinanBumil = BumilLahiran::where('tahun', $year)
            ->where('nama_kabupaten_kota', $kabkota)
            ->get();

        $persalinanBumil = $dataPersalinanBumil->groupBy('kegiatan_persalinan')->map(function ($items, $jenis) {
            $jumlah = $items->sum('jumlah_ibu_bersalin');
            return [
                'jenis' => $jenis,
                'jumlah' => $jumlah
            ];
        })->values();
        
        return view('pelayanan.KehamilanPersalinan', [
            'scoreboard' => $scoreboard,
            'year' => $year,
            'cities' => $cities,
            'kunjunganBumil' => $kunjunganBumil,
            'imunisasiBumil' => $imunisasiBumil,
            'tabletBumil' => $tabletBumil,
            'persalinanBumil' => $persalinanBumil,
            'years' => $years,
            'kabkota' => $kabkota
        ]);
    }

    public function importFromFileScoreboard()
    {
        // Tentukan path ke file Excel yang ingin diimpor
        $filePath = public_path('dataset/scoreboard_kehamilan_persalinan.xlsx');

        // Impor data
        Excel::import(new ScoreboardKehamilanPersalinanImport, $filePath);

        return back()->with('success', 'Data berhasil diimport dari file Excel.');
    }

    public function importFromFileKunjungan()
    {
        // Tentukan path ke file Excel yang ingin diimpor
        $filePath = public_path('dataset/dinkes-od_15946_jml_kunjungan_ibu_hamil__jenis_kunjungan_v3_data.xlsx');

        // Impor data
        Excel::import(new KunjunganBumilImport, $filePath);

        return back()->with('success', 'Data berhasil diimport dari file Excel.');
    }

    public function importFromFileImunisasi()
    {
        // Tentukan path ke file Excel yang ingin diimpor
        $filePath = public_path('dataset/dinkes-od_17387_jml_ibu_hamil_penerima_imunisasi_td__jenis_imunisa_v1_data.xlsx');

        // Impor data
        Excel::import(new BumilImunisasiTdImport, $filePath);

        return back()->with('success', 'Data berhasil diimport dari file Excel.');
    }

    public function importFromFileLahiran()
    {
        // Tentukan path ke file Excel yang ingin diimpor
        $filePath = public_path('dataset/dinkes-od_15937_jml_ibu_bersalin__kgtn_persalinan_v1_data.xlsx');

        // Impor data
        Excel::import(new BumilLahiranImport, $filePath);

        return back()->with('success', 'Data berhasil diimport dari file Excel.');
    }

    public function importFromFileTablet()
    {
        // Tentukan path ke file Excel yang ingin diimpor
        $filePath = public_path('dataset/dinkes-od_15938_jml_ibu_hamil_mendapatkan_tablet_zat_besi__jenis_t_v1_data.xlsx');

        // Impor data
        Excel::import(new BumilTabletZatBesiImport, $filePath);

        return back()->with('success', 'Data berhasil diimport dari file Excel.');
    }
}
