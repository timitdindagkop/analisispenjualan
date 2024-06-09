@extends('layout.main')
@section('container')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">{{ $title }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Laporan</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-7 col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h4>Data besaran Pendapatan</h4>
                        <div class="table-responsive">
                            <table id="penjualan" class="table table-bordered mb-0">
                                <thead>
                                    <tr class="text-center">
                                        <th width="5%">#</th>
                                        <th width="30%">Tanggal(X)</th>
                                        <th width="65%">Jumlah Barang(Y)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualan as $item)
                                    <tr class="text-center">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{ $item['bulan'] }}</td>
                                        <td>{{ $item['penjualan'] }} Kilo</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h4>Penyederhadaan Data</h4>
                        <div class="table-responsive">
                            <table id="penjualan" class="table table-bordered mb-0">
                                <thead>
                                    <tr class="text-center">
                                        <th width="5%">No</th>
                                        <th width="30%">X</th>
                                        <th width="65%">Y</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualan as $item)
                                    <tr class="text-center">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{ $item['no'] }}</td>
                                        <td>{{ $item['penjualan'] }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Nilai Perhitungan</h4>
                        <div class="table-responsive">
                            <table id="penjualan" class="table table-bordered mb-0">
                                <thead>
                                    <tr class="text-center">
                                        <th width="5%">No</th>
                                        <th width="15%">X</th>
                                        <th width="15%">Y</th>
                                        <th width="20%">X2</th>
                                        <th width="20%">Y2</th>
                                        <th width="25%">XY</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualan as $item)
                                    <tr class="text-center">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item['no'] }}</td>
                                        <td>{{ $item['penjualan'] }}</td>
                                        <td>{{$item['no'] * $item['no']}}</td>
                                        <td>{{ $item['penjualan']*$item['penjualan'] }}</td>
                                        <td>{{ $item['no']*$item['penjualan'] }}</td>
                                    </tr>
                                    <?php $totalno += $loop->iteration; ?>
                                    <?php $totalx += $item['no']; ?>
                                    <?php $totaly += $item['penjualan']; ?>
                                    <?php $totalx2 += $item['no']*$item['no']; ?>
                                    <?php $totaly2 += $item['penjualan'] * $item['penjualan']; ?>
                                    <?php $totalxy += $item['no'] * $item['penjualan']; ?>
                                @endforeach
                                <tr class="text-center">
                                    <td><strong>Total</strong></td>
                                    <td><strong>{{ $totalx }}</strong></td>
                                    <td><strong>{{ $totaly }}</strong></td>
                                    <td><strong>{{ $totalx2 }}</strong></td>
                                    <td><strong>{{ $totaly2 }}</strong></td>
                                    <td><strong>{{ $totalxy }}</strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5>Menghitung nilai Konstanta (a) dan koefisien (b)</h5>
                    <?php $konstanta_a = (($totaly*$totalx2) - ($totaly*$totalxy)) / (($totalno*$totalx2) - ($totalx*$totalx) )  ?>
                    <?php $koefisien_b = (($totalno*$totalxy) - ($totalx*$totaly)) / (($totalno*$totalx2) - ($totalx*$totalx) )  ?>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <tr class="text-center">
                                    <td><strong>Konstantan A</strong></td>
                                    <td><strong>Konstantan B</strong></td>
                                </tr>
                                <tr class="text-center">
                                    <td><strong>{{ $konstanta_a }}</strong></td>
                                    <td><strong>{{ $koefisien_b }}</strong></td>
                                </tr>
                            </table>
                        </div>
                        <?php $nilaiY = $konstanta_a + ($koefisien_b*$totalx)  ?>
                        <h5>Nilai dari persamaan dengan menggunakan metode regresi linear sederhana adalah sebagai berikut dimana Y = <strong>{{ round($nilaiY) }}</strong> <br />
                        Maka estimasi Stok barang pada besok hari tanggal {{ date('d-m-Y', strtotime('+1 day')) }} adalah sekitar {{ round($nilaiY) }} Kilo</h5>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->

@endsection