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
            <div class="col-lg-3">
                <div class="card-box">
                    <div class="media">
                        <div class="avatar-md bg-info rounded-circle mr-2">
                            <i class="ion-logo-usd avatar-title font-26 text-white"></i>
                        </div>
                        <div class="media-body align-self-center">
                            <div class="text-right">
                                <h4 class="font-20 my-0 font-weight-bold"><span data-plugin="counterup">{{ $penjualan }}</span></h4>
                                <p class="mb-0 mt-1 text-truncate">Penjualan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card-box">
                    <div class="media">
                        <div class="avatar-md bg-purple rounded-circle">
                            <i class="ion-md-cart avatar-title font-26 text-white"></i>
                        </div>
                        <div class="media-body align-self-center">
                            <div class="text-right">
                                <h4 class="font-20 my-0 font-weight-bold"><span data-plugin="counterup">{{ $pembelian }}</span></h4>
                                <p class="mb-0 mt-1 text-truncate">Pembelian</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card-box">
                    <div class="media">
                        <div class="avatar-md bg-success rounded-circle">
                            <i class="ion-md-contacts avatar-title font-26 text-white"></i>
                        </div>
                        <div class="media-body align-self-center">
                            <div class="text-right">
                                <h4 class="font-20 my-0 font-weight-bold"><span data-plugin="counterup">{{ $pembeli }}</span></h4>
                                <p class="mb-0 mt-1 text-truncate">Pembeli</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card-box">
                    <div class="media">
                        <div class="avatar-md bg-primary rounded-circle">
                            <i class="ion-md-eye avatar-title font-26 text-white"></i>
                        </div>
                        <div class="media-body align-self-center">
                            <div class="text-right">
                                <h4 class="font-20 my-0 font-weight-bold"><span data-plugin="counterup">{{ $barang }}</span></h4>
                                <p class="mb-0 mt-1 text-truncate">Barang</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
        
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card card-border card-primary">
                    <div class="card-header border-primary bg-transparent pb-0">
                        <h3 class="card-title text-primary">Penjualan dan pembelian</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="lineChartapp" data-type="Line" width="520" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end container-fluid -->
@endsection

@push('js')
    <!-- Chart JS -->
    <script src="/assets/libs/chart-js/Chart.bundle.min.js"></script>

    <script src="/assets/js/pages/chartjs.init.js"></script>
    <script>
        const ctx = document.getElementById("lineChartapp");
        const data = {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agt", "Sep", "Okt", "Nov", "Des"],
            datasets: [
                {
                    label: 'Transaksi Penjualan dan pembelian barang',
                    data: [<?= $penjualan_chart ?>],
                    borderColor: 'rgb(45, 196, 192)',
                },
                {
                    label: 'Transaksi Penjualan dan pembelian barang',
                    data: [<?= $pembelian_chat ?>],
                    borderColor: 'rgb(85, 136, 193)',
                }
            ]
        };

        var mychart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                display: true,
            },
            barValueSpacing: 20,
            scales: {
                yAxes: [{
                    ticks: {
                        min: 0,
                    },
                }],
                xAxes: [{
                    gridLines: {
                        color: "rgba(0, 0, 0, 0)",
                    }
                }]
            }
        })
    </script>
@endpush