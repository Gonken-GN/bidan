@extends('layouts.main')
@include('component.dateFilter')
@section('js')
<script>
    // Fetch data passed from the controller
    var dataKb = @json($totalKb);

    // Main series data
    const rdataKb = dataKb.map((item) => ({
        name: item.metode, 
        y: item.jumlah,
        drilldown: item.metode // Use metode as the id for drilldown
    }));

    // Drilldown series data
    const drilldownSeries = dataKb.map((item) => ({
        id: item.metode,
        name: `Detail untuk metode ${item.metode}`,
        data: item.jenis_kb.map((detail) => [detail.name, detail.y]) // Convert detail data to format required by Highcharts
    }));

    // Initialize the chart
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Jumlah Peserta KB per Metode'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Jumlah Peserta'
            }
        },
        series: [{
            name: 'Metode KB',
            data: rdataKb
        }],
        drilldown: {
            series: drilldownSeries
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
    <!-- Page Heading -->
    {{-- <div class="mb-4">
        <div class="card shadow">
            <div class="card-body row">
                <div class="col">
                    <form action="{{ route('kb_lengkap.index') }}" method="GET">
                        @csrf
                        @method('POST')

                        <label for="datepicker">Mulai Tanggal:</label>
                        <input type="date" class="form-control" placeholder="Pilih tanggal" name="awal"
                            value="{{ $awal }}">
                </div>
                <div class="col">

                    <label for="datepicker">Sampai Tanggal:</label>
                    <input type="date" class="form-control" placeholder="Pilih tanggal" name="akhir"
                        value="{{ $akhir }}">
                </div>
                <div class="align-items-center d-flex pt-3">
                    <button class="btn btn-info">Tampilkan</button>
                </div>
                
            </div>
        </div>
    </div> --}}
    <div class="mb-4">
        <div class="card shadow">
            <div class="card-body row">
                <div class="col">
                    <form action="{{ route('kb_lengkap.index') }}" method="GET">
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
        <!-- Jumlah Bayi Laki-laki di Imunisasi -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Metode KB yang paling banyak digunakan :
                            </div>
                            @if($mostCommonMetodeKb)
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $mostCommonMetodeKb['metode'] }} ({{ $mostCommonMetodeKb['jumlah'] }} Peserta)
                                </div>
                            @else
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    Tidak ada data tersedia
                                </div>
                            @endif

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
                                Jenis Kb yang paling banyak digunakan
                            </div>
                            @if($mostCommonMetodeKb)
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $mostCommonJenisKb }}</div>
                            @else
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    Tidak ada data tersedia
                                </div>
                            @endif
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
                                Jumlah Peserta KB
                            </div>
                            @if($totalParticipants)
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalParticipants }}</div>
                            @else
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    0
                                </div>
                            @endif
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-female fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
        <!-- Pilih Provinsi -->
        {{-- <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    {{-- <form action="" method="POST">
                        @csrf --}}
                        {{-- <div class="form-group">
                            <label for="city">Pilih Kabupaten/Kota</label>
                            <select class="form-control" id="kabkota" name="kabkota">
                                @foreach($cities as $city)
                                    <option value="{{ $city }}">{{ $city }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="align-items-center d-flex pt-3">
                            <button type="submit" class="btn btn-info">Tampilkan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
    
    {{-- </form> --}}
    {{-- -------------------------------------------- END SCOREBOARD --------------------------------------- --}}


    {{-- ----------------------------------------------- DIAGRAM 1 -------------------------------------------- --}}
    <figure class="highcharts-figure">
        <div id="container"></div>
        <p class="highcharts-description">
            A basic column chart comparing estimated corn and wheat production
            in some countries.

            The chart is making use of the axis crosshair feature, to highlight
            the hovered country.
        </p>
    </figure>





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
                <form action="{{ route('kblengkap.importFromFile') }}" method="GET" enctype="multipart/form-data">
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
