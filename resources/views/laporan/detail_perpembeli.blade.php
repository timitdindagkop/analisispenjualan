@extends('layout.main')
@push('css')
    <!-- Table datatable css -->
    <link href="/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endpush
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
                            <li class="breadcrumb-item"><a href="#">Penjualan</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Pembeli</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-12">
                                <p>Rekapan pembeli di hitung berdasarkan rekap bulan ini</p>
                                <table id="data-pembelianbarang" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="20%">Tanggal</th>
                                            <th width="30%">Total pembelian</th>
                                            <th width="25%">Total Barang (Kiloan)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <?php $total_uang += $item->total_uang; ?>
                                                <?php $total_barang += $item->total_barang; ?>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ date('d-m-Y', strtotime($item->tanggal)) }}</td>
                                                <td>Rp. {{ number_format($item->total_uang,0,',','.') }}</td>
                                                <td>{{ $item->total_barang }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2" class="text-right"><strong>Total</strong></td>
                                            <td><strong>Rp. {{ number_format($total_uang,0,',','.') }}</strong></td>
                                            <td><strong>{{ $total_barang }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->
    </div>
    <!-- end container-fluid -->
@endsection
@push('js')
    
    <!-- third party js -->
    <script src="/assets/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="/assets/libs/datatables/responsive.bootstrap4.min.js"></script>
@endpush