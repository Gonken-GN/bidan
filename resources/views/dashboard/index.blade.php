@extends('layouts.main')
@include('component.dateFilter')
@section('js')
<script>
    // Assuming $dataImunisasi, $dataKb, $dataIbuBersalin, and $dataBumil are properly passed from Laravel
    const chartDataImunisasi = @json($dataImunisasi);
    const chartDataKb = @json($dataKb);
    const chartDataIbuBersalin = @json($dataIbuBersalin);
    const chartDataBumil = @json($dataBumil);

    // Assuming $year is an array of years to be used for the xAxis categories
    const years = @json($year);

    // Log the data to ensure they are correct

    Highcharts.chart('container', {
        title: {
            text: 'Jumlah Bayi Imunisasi, Peserta KB, Ibu Bersalin, dan Ibu Hamil di Jawa Barat dari Tahun ke Tahun',
            align: 'left'
        },
        yAxis: {
            title: {
                text: 'Jumlah'
            }
        },
        xAxis: {
            categories: years, // Set years as categories
            title: {
                text: 'Tahun'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                }
            }
        },
        series: [{
            name: 'Jumlah Bayi Imunisasi',
            data: years.map(year => chartDataImunisasi[year] ? parseInt(chartDataImunisasi[year], 10) : null)
        }, {
            name: 'Jumlah Peserta KB',
            data: years.map(year => chartDataKb[year] ? parseInt(chartDataKb[year], 10) : null)
        }, {
            name: 'Jumlah Ibu Bersalin',
            data: years.map(year => chartDataIbuBersalin[year] ? parseInt(chartDataIbuBersalin[year], 10) : null)
        }, {
            name: 'Jumlah Ibu Hamil',
            data: years.map(year => chartDataBumil[year] ? parseInt(chartDataBumil[year], 10) : null)
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    });
</script>
@endsection


<style>
    .highcharts-figure,
    .highcharts-data-table table {
        min-width: 310px;
        max-width: 800px;
        margin: 1em auto;
    }

    #container {
        height: 400px;
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #ebebeb;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }

    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }

    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }

    .highcharts-data-table td,
    .highcharts-data-table th,
    .highcharts-data-table caption {
        padding: 0.5em;
    }

    .highcharts-data-table thead tr,
    .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }

    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }
</style>

@section('content')
<div class="row">
    <!-- Jumlah Resti Ibu Hamil -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Jenis Imunisasi Paling Banyak: 
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $topImunisasi->jenis_imunisasi }} pada Tahun: {{ $topImunisasi->tahun }}
                            di {{ $topImunisasi->nama_kabupaten_kota }}
                            dengan total {{ $topImunisasi->total }} orang
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-male fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jumlah Bayi Perempuan di Imunisasi -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Jumlah Perkiraan Ibu Hamil dengan Komplikasi Bidan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{-- {{ $scoreboard['komplikasi'] }} Orang --}}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-female fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Jumlah Kematian Ibu Hamil Pasca Persalinan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{-- {{ $scoreboard['kematian'] }} Orang --}}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-female fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description">
        A basic column chart comparing estimated corn and wheat production
        in some countries.

        The chart is making use of the axis crosshair feature, to highlight
        the hovered country.
    </p>
</figure>
@endsection