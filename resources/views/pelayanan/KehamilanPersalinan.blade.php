@extends('layouts.main')
@include('component.dateFilter')
@section('js')
<script>
    // Fetch data passed from the controller
    var dataKunjunganBumil = @json($kunjunganBumil);

    // Main series data
    const rdataKunjunganBumil = dataKunjunganBumil.map((item) => ({
        name: item.jenis, 
        y: item.jumlah,
    }));

    // Initialize the chart
    Highcharts.chart('kunjunganBumil', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Jumlah Kunjungan Ibu Hamil berdasarkan Jenis Kunjungan'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Jumlah Ibu Hamil'
            }
        },
        series: [{
            name: 'Jenis Kunjungan',
            data: rdataKunjunganBumil
        }]
    });
</script>

<script>
    // Fetch data passed from the controller
    var dataImunisasiBumil = @json($imunisasiBumil);

    // Main series data
    const rdataImunisasiBumil = dataImunisasiBumil.map((item) => ({
        name: item.jenis, 
        y: item.jumlah,
    }));

    // Initialize the chart
    Highcharts.chart('ImunisasiBumil', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Jumlah Ibu Hamil Penerima Imunisasi Tetanus Difteri'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Jumlah Ibu Hamil'
            }
        },
        series: [{
            name: 'Jenis Imunisasi Tetanus Difteri',
            data: rdataImunisasiBumil
        }]
    });
</script>

<script>
    // Fetch data passed from the controller
    var dataPersalinanBumil = @json($persalinanBumil);

    // Main series data
    const rdataPersalinanBumil = dataPersalinanBumil.map((item) => ({
        name: item.jenis, 
        y: item.jumlah,
    }));

    // Initialize the chart
    Highcharts.chart('PersalinanBumil', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Jumlah Persalinan Ibu Hamil berdasarkan Kegiatan Persalinan'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Jumlah Ibu Bersalin'
            }
        },
        series: [{
            name: 'Kegiatan Persalinan',
            data: rdataPersalinanBumil
        }]
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
                    <form action="{{ route('kehamilan_persalinan.index') }}" method="GET">
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
    <div class="row">
        <!-- Jumlah Resti Ibu Hamil -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Ibu Hamil yang Mengalami Resiko Tinggi Kehamilan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $scoreboard['resti'] }} Orang
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
                                {{ $scoreboard['komplikasi'] }} Orang
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
                                {{ $scoreboard['kematian'] }} Orang
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
    <div class="row justify-content-center">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Jumlah Ibu Hamil Penerima Tablet Tambah Darah
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $scoreboard['ttd'] }} Orang
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
                                Jumlah Ibu Hamil Penerima Tablet Zat Besi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @foreach($tabletBumil as $tablet)
                                   Tablet {{ $tablet['jenis'] }} : {{ $tablet['jumlah'] }} Orang
                                @endforeach
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
    
    {{-- </form> --}}
    {{-- -------------------------------------------- END SCOREBOARD --------------------------------------- --}}


    {{-- ----------------------------------------------- DIAGRAM 1 -------------------------------------------- --}}
    <div class="container">
        <div class="row">
          <div class="col">
            <figure class="highcharts-figure">
                <div id="kunjunganBumil"></div>
            </figure>
          </div>
          <div class="col">
            <figure class="highcharts-figure">
                <div id="ImunisasiBumil"></div>
            </figure>
          </div>
          <div class="col">
            <figure class="highcharts-figure">
                <div id="PersalinanBumil"></div>
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
                <form action="{{ route('kehamilanpersalinan.importFromFileScoreboard') }}" method="GET" enctype="multipart/form-data">
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
