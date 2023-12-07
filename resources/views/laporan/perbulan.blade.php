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
            <div class="col-lg-6">
                <div class="card card-border">
                    <div class="card-header border-info bg-transparent pb-0">
                        <h3 class="card-title text-info">Pendapatan</h3>
                    </div>
                    <div class="card-body">
                        <h4 class="mb-0">Total Pendapatan pada tahun {{ date('Y') }}</h4>
                        <h4 id="total_penjualan">Rp. <div class="spinner-grow text-success m-1" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                        </h4>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="card card-border">
                    <div class="card-header border-info bg-transparent pb-0">
                        <h3 class="card-title text-info">Pembelian</h3>
                    </div>
                    <div class="card-body">
                        <h4 class="mb-0">Total Pembelian pada tahun {{ date('Y') }}</h4>
                        <h4 id="total_pembelian">Rp. <div class="spinner-grow text-success m-1" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                        </h4>
                    </div>
                </div>
            </div>


            <div class="col-lg-4">
                <div class="card card-border">
                    <div class="card-header border-info bg-transparent pb-0">
                        <h3 class="card-title text-info"><a href="{{ url('lpbb') }}?bulan=01">Januari</a></h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="mb-0">Total Pendapatan.</p>
                                <h4 id="penjualan_jan">Rp. <div class="spinner-grow text-success m-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                </h4>
                            </div>
                            <div>
                                <p class="mb-0">Total Pembelian.</p>
                                <h4 id="pembelian_jan">Rp. <div class="spinner-grow text-success m-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-border">
                    <div class="card-header border-info bg-transparent pb-0">
                        <h3 class="card-title text-info"><a href="{{ url('lpbb') }}?bulan=02">Februari</a></h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="mb-0">Total Pendapatan.</p>
                                <h4 id="penjualan_feb">Rp. <div class="spinner-grow text-success m-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                </h4>
                            </div>
                            <div>
                                <p class="mb-0">Total Pembelian.</p>
                                <h4 id="pembelian_feb">Rp. <div class="spinner-grow text-success m-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-border">
                    <div class="card-header border-info bg-transparent pb-0">
                        <h3 class="card-title text-info"><a href="{{ url('lpbb') }}?bulan=03">Maret</a></h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="mb-0">Total Pendapatan.</p>
                                <h4 id="penjualan_mar">Rp. <div class="spinner-grow text-success m-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                </h4>
                            </div>
                            <div>
                                <p class="mb-0">Total Pembelian.</p>
                                <h4 id="pembelian_mar">Rp. <div class="spinner-grow text-success m-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-border">
                    <div class="card-header border-info bg-transparent pb-0">
                        <h3 class="card-title text-info"><a href="{{ url('lpbb') }}?bulan=04">April</a></h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="mb-0">Total Pendapatan.</p>
                                <h4 id="penjualan_apr">Rp. <div class="spinner-grow text-success m-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                </h4>
                            </div>
                            <div>
                                <p class="mb-0">Total Pembelian.</p>
                                <h4 id="pembelian_apr">Rp. <div class="spinner-grow text-success m-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-border">
                    <div class="card-header border-info bg-transparent pb-0">
                        <h3 class="card-title text-info"><a href="{{ url('lpbb') }}?bulan=05">Mei</a></h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="mb-0">Total Pendapatan.</p>
                                <h4 id="penjualan_mei">Rp. <div class="spinner-grow text-success m-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                </h4>
                            </div>
                            <div>
                                <p class="mb-0">Total Pembelian.</p>
                                <h4 id="pembelian_mei">Rp. <div class="spinner-grow text-success m-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-border">
                    <div class="card-header border-info bg-transparent pb-0">
                        <h3 class="card-title text-info"><a href="{{ url('lpbb') }}?bulan=06">Juni</a></h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="mb-0">Total Pendapatan.</p>
                                <h4 id="penjualan_jun">Rp. <div class="spinner-grow text-success m-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                </h4>
                            </div>
                            <div>
                                <p class="mb-0">Total Pembelian.</p>
                                <h4 id="pembelian_jun">Rp. <div class="spinner-grow text-success m-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-border">
                    <div class="card-header border-info bg-transparent pb-0">
                        <h3 class="card-title text-info"><a href="{{ url('lpbb') }}?bulan=07">Juli</a></h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="mb-0">Total Pendapatan.</p>
                                <h4 id="penjualan_jul">Rp. <div class="spinner-grow text-success m-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                </h4>
                            </div>
                            <div>
                                <p class="mb-0">Total Pembelian.</p>
                                <h4 id="pembelian_jul">Rp. <div class="spinner-grow text-success m-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card card-border">
                    <div class="card-header border-info bg-transparent pb-0">
                        <h3 class="card-title text-info"><a href="{{ url('lpbb') }}?bulan=08">Agustus</a></h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="mb-0">Total Pendapatan.</p>
                                <h4 id="penjualan_agt">Rp. <div class="spinner-grow text-success m-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                </h4>
                            </div>
                            <div>
                                <p class="mb-0">Total Pembelian.</p>
                                <h4 id="pembelian_agt">Rp. <div class="spinner-grow text-success m-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-border">
                    <div class="card-header border-info bg-transparent pb-0">
                        <h3 class="card-title text-info"><a href="{{ url('lpbb') }}?bulan=09">September</a></h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="mb-0">Total Pendapatan.</p>
                                <h4 id="penjualan_sep">Rp. <div class="spinner-grow text-success m-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                </h4>
                            </div>
                            <div>
                                <p class="mb-0">Total Pembelian.</p>
                                <h4 id="pembelian_sep">Rp. <div class="spinner-grow text-success m-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-border">
                    <div class="card-header border-info bg-transparent pb-0">
                        <h3 class="card-title text-info"><a href="{{ url('lpbb') }}?bulan=10">Oktober</a></h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="mb-0">Total Pendapatan.</p>
                                <h4 id="penjualan_okt">Rp. <div class="spinner-grow text-success m-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                </h4>
                            </div>
                            <div>
                                <p class="mb-0">Total Pembelian.</p>
                                <h4 id="pembelian_okt">Rp. <div class="spinner-grow text-success m-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-border">
                    <div class="card-header border-info bg-transparent pb-0">
                        <h3 class="card-title text-info"><a href="{{ url('lpbb') }}?bulan=11">November</a></h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="mb-0">Total Pendapatan.</p>
                                <h4 id="penjualan_nov">Rp. <div class="spinner-grow text-success m-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                </h4>
                            </div>
                            <div>
                                <p class="mb-0">Total Pembelian.</p>
                                <h4 id="pembelian_nov">Rp. <div class="spinner-grow text-success m-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-border">
                    <div class="card-header border-info bg-transparent pb-0">
                        <h3 class="card-title text-info"><a href="{{ url('lpbb') }}?bulan=12">Desember</a></h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="mb-0">Total Pendapatan.</p>
                                <h4 id="penjualan_des">Rp. <div class="spinner-grow text-success m-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                </h4>
                            </div>
                            <div>
                                <p class="mb-0">Total Pembelian.</p>
                                <h4 id="pembelian_des">Rp. <div class="spinner-grow text-success m-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->

@endsection

@push('js')

    <script>
        const rupiah = (number) => {
            return new Intl.NumberFormat("id-ID", {
            style: "decimal",
            currency: "IDR"
            }).format(number);
        }

        $(document).ready(() => {
            tabel();
        });

        function tabel(){
            $.ajax({
                url: "{{ url('json_lpb') }}",
                type: 'GET',
                dataType: 'json',
                success: function(response){
                    $('#total_penjualan').html("Rp. "+rupiah(response.data['0'].total.penjualan));
                    $('#total_pembelian').html("Rp. "+rupiah(response.data['0'].total.pembelian));
                    
                    $('#penjualan_jan').html("Rp. "+rupiah(response.data['0'].jan.penjualan));
                    $('#pembelian_jan').html("Rp. "+rupiah(response.data['0'].jan.pembelian));
                    
                    $('#penjualan_feb').html("Rp. "+rupiah(response.data['0'].feb.penjualan));
                    $('#pembelian_feb').html("Rp. "+rupiah(response.data['0'].feb.pembelian));
                    
                    $('#penjualan_mar').html("Rp. "+rupiah(response.data['0'].mar.penjualan));
                    $('#pembelian_mar').html("Rp. "+rupiah(response.data['0'].mar.pembelian));
                    
                    $('#penjualan_apr').html("Rp. "+rupiah(response.data['0'].apr.penjualan));
                    $('#pembelian_apr').html("Rp. "+rupiah(response.data['0'].apr.pembelian));
                    
                    $('#penjualan_mei').html("Rp. "+rupiah(response.data['0'].mei.penjualan));
                    $('#pembelian_mei').html("Rp. "+rupiah(response.data['0'].mei.pembelian));
                    
                    $('#penjualan_jun').html("Rp. "+rupiah(response.data['0'].jun.penjualan));
                    $('#pembelian_jun').html("Rp. "+rupiah(response.data['0'].jun.pembelian));
                    
                    $('#penjualan_jul').html("Rp. "+rupiah(response.data['0'].jul.penjualan));
                    $('#pembelian_jul').html("Rp. "+rupiah(response.data['0'].jul.pembelian));
                    
                    $('#penjualan_agt').html("Rp. "+rupiah(response.data['0'].agt.penjualan));
                    $('#pembelian_agt').html("Rp. "+rupiah(response.data['0'].agt.pembelian));
                    
                    $('#penjualan_sep').html("Rp. "+rupiah(response.data['0'].sep.penjualan));
                    $('#pembelian_sep').html("Rp. "+rupiah(response.data['0'].sep.pembelian));
                    
                    $('#penjualan_okt').html("Rp. "+rupiah(response.data['0'].okt.penjualan));
                    $('#pembelian_okt').html("Rp. "+rupiah(response.data['0'].okt.pembelian));
                    
                    $('#penjualan_nov').html("Rp. "+rupiah(response.data['0'].nov.penjualan));
                    $('#pembelian_nov').html("Rp. "+rupiah(response.data['0'].nov.pembelian));
                    
                    $('#penjualan_des').html("Rp. "+rupiah(response.data['0'].des.penjualan));
                    $('#pembelian_des').html("Rp. "+rupiah(response.data['0'].des.pembelian));
                    
                }
            });
        }
    </script>
@endpush