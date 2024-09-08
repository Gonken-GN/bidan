@extends('layouts.main')
@include('component.dateFilter')
@section('js')
    <script>
        // console.log("TEST");

        // Masukkan data ke variable
        var dataImunisasi = @json($y_data);
        var dataDrilldown = @json($drilldown);

        // Menyesuaikan data dengan format grafik dan drilldown
        // Transform the data to match the required format for Highcharts
        const rdataImunisasi = Object.keys(dataImunisasi).map((key) => ({
            name: key,
            y: dataImunisasi[key],
            drilldown: key
        }));

        const drilldownSeries = Object.keys(dataDrilldown).map((key) => ({
            id: key,
            name: `Detail untuk jenis imunisasi ${key}`,
            data: dataDrilldown[key] // Format already as needed for Highcharts
        }));

        Highcharts.chart('imunisasi', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Total Imunisasi per Jenis',
                align: 'left'
            },
            subtitle: {
                text: 'Data Imunisasi per Jenis Vaksin.',
                align: 'left'
            },
            xAxis: {
                type: 'category',
                crosshair: true,
                accessibility: {
                    description: 'Jenis Vaksin'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah Orang'
                }
            },
            tooltip: {
                valueSuffix: ' Orang'
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Jenis Imunisasi',
                data: rdataImunisasi
            }],
            drilldown: {
                series: drilldownSeries
            }
        });
    </script>

    <script>
        var dataImunisasibyGender = @json($genderData);
        const rdataImunisasibyGender = Object.keys(dataImunisasibyGender).map((key) => ({
            name: key,
            y: dataImunisasibyGender[key],
        }));

        Highcharts.chart('perbandingan', {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Perbandingan Imunisasi berdasarkan Jenis Kelamin'
        },
        tooltip: {
            valueSuffix: '%'
        },
        subtitle: {
            text:
            'Source:<a href="https://www.mdpi.com/2072-6643/11/3/684/htm" target="_default">MDPI</a>'
        },
        plotOptions: {
            series: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: [{
                    enabled: true,
                    distance: 20
                }, {
                    enabled: true,
                    distance: -40,
                    format: '{point.percentage:.1f}%',
                    style: {
                        fontSize: '1.2em',
                        textOutline: 'none',
                        opacity: 0.7
                    },
                    filter: {
                        operator: '>',
                        property: 'percentage',
                        value: 10
                    }
                }]
            }
        },
        series: [
            {
                name: 'Percentage',
                colorByPoint: true,
                data: rdataImunisasibyGender
            }
        ]
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
    <!-- Page Heading -->
    <div class="mb-4">
        <div class="card shadow">
            <div class="card-body row">
                <div class="col">
                    <form action="{{ route('imunisasi_lengkap.index') }}" method="GET">
                        @csrf
                        @method('POST')
    
                        <label for="yearpicker">Pilih Tahun:</label>
                        <select class="form-control" name="year">
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ $year == old('year', request('year')) ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                </div>
                <div class="col">
                    <label for="citypicker">Pilih Kabupaten/Kota:</label>
                    <select class="form-control" name="kabkota">
                        @foreach($cities as $city)
                            <option value="{{ $city }}" {{ $city == old('kabkota', request('kabkota')) ? 'selected' : '' }}>
                                {{ $city }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="align-items-center d-flex pt-3">
                    <button class="btn btn-info">Tampilkan</button>
                </div>
            </div>
        </form>
        </div>
    </div>

    {{-- Pesan Sukses --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {!! session('success') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {!! session('error') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- -------------------------------------------- SCOREBOARD --------------------------------------- --}}
    {{-- <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Bayi Laki-laki di Imunisasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalbayilaki }} Bayi</div>
                            {{-- <div class="h5 mb-0 font-weight-bold text-gray-800"></div> --}}
                        {{-- </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                            {{-- <i class="fas fa-calendar fa-2x text-gray-300"></i> --}}
                        {{-- </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Earnings (Monthly) Card Example -->
        {{-- <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Jumlah Bayi Perempuan di Imunisasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalbayiperempuan }} Bayi</div>

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
            <label for="citypicker">Pilih Provinsi</label>
            <input type="text" class="form-control" placeholder="Pilih provinsi" name="provinsi"
                value="{{ $provinsi }}">
        </div>
        <div class="align-items-center d-flex pt-3">
            <button class="btn btn-info">Tampilkan</button>
        </div>
        </div>
    </div> --}}

    <div class="row">
        <!-- Jumlah Bayi Imunisasi -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Jumlah Bayi Imunisasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalbayi }} Bayi</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-female fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Jumlah Bayi Laki-laki di Imunisasi -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jenis Imunisasi yang paling banyak digunakan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $mostCommonImmunization }}</div>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Jumlah Bayi di Imunisasi {{ $mostCommonImmunization }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $immunizationSums[$mostCommonImmunization] }} Bayi</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-female fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- </form> --}}
    {{-- -------------------------------------------- END SCOREBOARD --------------------------------------- --}}


    {{-- ----------------------------------------------- DIAGRAM 1 -------------------------------------------- --}}
    


    
    <div class="container text-center">
        <div class="row">
          <div class="col">
            
            <figure class="highcharts-figure">
                <div id="imunisasi" class="imunisasi"></div>
                <p class="highcharts-description">
                    A basic column chart comparing estimated corn and wheat production
                    in some countries.
        
                    The chart is making use of the axis crosshair feature, to highlight
                    the hovered country.
                </p>
            </figure>
          </div>
          <div class="col">
            
            <figure class="highcharts-figure">
                <div id="perbandingan" class="perbandingan"></div>
                <p class="highcharts-description">
                    Pie charts are very popular for showing a compact overview of a
                    composition or comparison. While they can be harder to read than
                    column charts, they remain a popular choice for small datasets.
                </p>
            </figure>
          </div>
        </div>
    </div>





    <div class="card shadow mb-4">
        <div class="card-body d-flex">
            <!-- Button trigger modal -->
            <div class="p-2">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Import
                </button>
            </div>

            {{-- <div class="p-2">
                <a href="/export-excel-kb">
                    <button type="button" class="btn btn-success">
                        Export
                    </button>
                </a>
            </div> --}}
        </div>
    </div>



    {{-- Pesan Error --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Modal Dialog Import -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('imunisasilengkap.importFromFile') }}" method="GET" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <label for="exampleFormControlFile1">Excel file</label>
                        <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Dialog Import -->
@endsection
