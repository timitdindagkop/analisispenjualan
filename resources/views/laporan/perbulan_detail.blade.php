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
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Penjualan</h4>
                        <div class="table-responsive">
                            <table id="penjualan" class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Pembeli</th>
                                        <th>tanggal</th>
                                        <th>Uang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualan as $jual)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $jual->pembeli->nama_pembeli }}</td>
                                            <td>{{ date('d/m/Y', strtotime($jual->tanggal)) }}</td>
                                            <td>Rp. {{ number_format($jual->total_uang,0,',','.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Pembelian</h4>
                        <div class="table-responsive">
                            <table id="pembelian" class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Suplier</th>
                                        <th>tanggal</th>
                                        <th>Uang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pembelian as $beli)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $beli->suplier->nama_perusahaan }}</td>
                                            <td>{{ date('d/m/Y', strtotime($beli->tanggal)) }}</td>
                                            <td>Rp. {{ number_format($beli->total_uang,0,',','.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->

@endsection