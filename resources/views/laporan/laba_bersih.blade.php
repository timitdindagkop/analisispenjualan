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
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Laba penjualan</h4>
                        <div class="table-responsive">
                            <table id="penjualan" class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="30%">Bulan</th>
                                        <th width="65%">Laba</th>
                                        {{-- <th width="15%">Detail</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($laba as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{ $item['bulan'] }}</td>
                                            <td>Rp. {{ number_format($item['laba'],0,',','.') }}</td>
                                            {{-- <td><a href="#" class="btn btn-sm btn-primary">Detail</a></td> --}}
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