<?php

namespace App\Http\Controllers;

use App\Models\BumilLahiran;
use App\Models\IbuBersalin;
use App\Models\ImunisasiLengkap;
use App\Models\JenisImunisasi;
use App\Models\KbLengkap;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Line Chart Data: Jumlah Bayi Imunisasi Jawa Barat dari Tahun ke Tahun
        $lineChartImunisasi = ImunisasiLengkap::selectRaw('tahun, SUM(jumlah_bayi) as total')
            ->whereBetween('tahun', [2018, 2021])
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();


        // Line Chart Data: Jumlah Peserta KB Jawa Barat dari Tahun ke Tahun
        $lineChartKb = KbLengkap::selectRaw('tahun, SUM(jumlah_peserta) as total')
            ->whereBetween('tahun', [2018, 2021])
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        // Line Chart Data: Jumlah Ibu Bersalin Jawa Barat dari Tahun ke Tahun
        $lineChartIbuBersalin = IbuBersalin::selectRaw('tahun, SUM(jumlah_ibu_bersalin) as total')
            ->whereBetween('tahun', [2018, 2021])
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        // Line Chart Data: Jumlah Ibu Hamil Jawa Barat dari Tahun ke Tahun
        $lineChartBumil = IbuBersalin::selectRaw('tahun, SUM(jumlah_ibu_hamil) as total')
            ->whereBetween('tahun', [2018, 2021])
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        // Scoreboard: Jenis imunisasi paling banyak apa, terjadi di tahun berapa dan kota mana
        $totals = JenisImunisasi::selectRaw('
            tahun,
            nama_kabupaten_kota,
            SUM(jumlah_bayi_hepatitis) as total_hepatitis,
            SUM(jumlah_bayi_campak) as total_campak,
            SUM(jumlah_bayi_polio) as total_polio,
            SUM(jumlah_bayi_bcg) as total_bcg
        ')
        ->groupBy('tahun', 'nama_kabupaten_kota')
        ->get();

        $topImunisasi = $totals->map(function($row) {
            $maxValue = max($row->total_hepatitis, $row->total_campak, $row->total_polio, $row->total_bcg);
            
            if ($maxValue == $row->total_hepatitis) {
                $row->jenis_imunisasi = 'Hepatitis';
            } elseif ($maxValue == $row->total_campak) {
                $row->jenis_imunisasi = 'Campak';
            } elseif ($maxValue == $row->total_polio) {
                $row->jenis_imunisasi = 'Polio';
            } elseif ($maxValue == $row->total_bcg) {
                $row->jenis_imunisasi = 'BCG';
            }
            
            $row->total = $maxValue;
            return $row;
        });
        
        // Ambil imunisasi dengan total terbesar
        $topImunisasi = $topImunisasi->sortByDesc('total')->first();
        

        // Scoreboard: Jenis KB paling banyak apa, terjadi di tahun berapa dan kota mana
        $topKb = KbLengkap::selectRaw('jenis_kb, tahun, nama_kabupaten_kota, SUM(jumlah_peserta) as total')
            ->groupBy('jenis_kb', 'tahun', 'nama_kabupaten_kota')
            ->orderByDesc('total')
            ->first();

        // Scoreboard: Kegiatan Persalinan paling banyak apa, terjadi di tahun berapa dan kota mana
        $topKegiatanPersalinan = BumilLahiran::selectRaw('kegiatan_persalinan, tahun, nama_kabupaten_kota, SUM(jumlah_ibu_bersalin) as total')
            ->groupBy('kegiatan_persalinan', 'tahun', 'nama_kabupaten_kota')
            ->orderByDesc('total')
            ->first();

        // Convert to JSON for use in Highcharts
        $dataImunisasi = $lineChartImunisasi->pluck('total', 'tahun')->toArray();
        $dataKb = $lineChartKb->pluck('total', 'tahun')->toArray();
        $dataIbuBersalin = $lineChartIbuBersalin->pluck('total', 'tahun')->toArray();
        $dataBumil = $lineChartBumil->pluck('total', 'tahun')->toArray();

        // // Bar Race: Top 5 Kab/Kota dengan jumlah pengguna layanan paling banyak
        // $topKabKota = Imunisasi::selectRaw('nama_kabupaten_kota, SUM(jumlah_bayi) as total')
        //     ->groupBy('nama_kabupaten_kota')
        //     ->orderByDesc('total')
        //     ->limit(5)
        //     ->get();

        // // Optional: Persebaran kota dengan jumlah pengguna layanan (Contoh data - bisa disesuaikan)
        // $persebaranKota = Imunisasi::selectRaw('nama_kabupaten_kota, SUM(jumlah_bayi) as total')
        //     ->groupBy('nama_kabupaten_kota')
        //     ->get();

        // // Gauge Chart: Pengukuran Jumlah Bayi Imunisasi dari Total Bayi
        // $totalBayi = Bumil::sum('jumlah_bayi_total');
        // $totalImunisasi = Imunisasi::sum('jumlah_bayi');

        // $gaugeChartValue = $totalImunisasi / $totalBayi * 100;
        // dd($dataImunisasi, $dataKb, $dataIbuBersalin, $dataBumil);
        // dd($dataImunisasi, $dataKb, $dataIbuBersalin);
        return view('dashboard.index', [
            'dataImunisasi' => $dataImunisasi,
            'dataKb' => $dataKb,
            'dataIbuBersalin' => $dataIbuBersalin,
            'dataBumil' => $dataBumil,
            'year' => [2018, 2019, 2020, 2021],
            'topImunisasi' => $topImunisasi,
            'topKb' => $topKb,
            'topKegiatanPersalinan' => $topKegiatanPersalinan,

        ]);
        // return view('dashboard.index', compact(
        //     // 'lineChartImunisasi',
        //     // 'lineChartKb',
        //     // 'lineChartBumil',
        //     // 'lineChartIbuBersalin',
        //     // 'topImunisasi',
        //     // 'topKb',
        //     // 'topKegiatanPersalinan',
        //     // 'topKabKota',
        //     // 'persebaranKota',
        //     // 'gaugeChartValue'
        // ));
    }
}
