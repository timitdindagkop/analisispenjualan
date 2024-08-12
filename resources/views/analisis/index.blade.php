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
            @foreach ($penjualan as $item)
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4>{{ $item['barang_name'] }}</h4>
                        <h6>Estimasi penjualan tanggal {{ date('d/m/Y') }} = {{ round($item['Y']) }} kilo</h6>
                    </div>
                </div>
            </div>                
            @endforeach

        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Nilai Perhitungan</h4>
                        <select name="barang" id="barang" class="form-control mb-3">
                            <option value="bd9b56e6-4a80-46d7-b774-82427d7b3774">Merk SIIP</option>
                            <option value="abc49e26-ffc0-46bf-bba1-754ae062435a">Merk SGR</option>
                            <option value="f58cc48c-069b-49ae-95ac-84bf8c987975">Merk MBR</option>
                            <option value="bdbcb169-ae70-4071-92d0-9c6caccd3e63">Merk SBS</option>
                            <option value="c1c7cea1-636c-4345-818b-a2dc774b9088">Merk Tulip</option>
                        </select>
                        <span>Keterangan : X adalah hari ke, Y adalah jumlah barang terjual</span>
                        <div class="table-responsive" id="penjualan">
                            <table id="tabel-penjualan" class="table table-bordered mb-0">
                                <thead>
                                    <tr class="text-center">
                                        <th width="20%">Tanggal</th>
                                        <th width="10%">X (Hari ke-)</th>
                                        <th width="10%">Y (Jumlah)</th>
                                        <th width="20%">X2</th>
                                        <th width="20%">Y2</th>
                                        <th width="20%">XY</th>
                                    </tr>
                                </thead>
                                <tbody>
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

@push('js')
<script>
    $(document).ready(function(event){
        loaddata();
    });

    $(document).on('change', '#barang', function(e){
        e.preventDefault();
        loaddata();
    });

    function loaddata(){
        $('#penjualan table tbody').empty();
        $.ajax({
            url: "{{url('getAnalisis')}}",
            type: "GET",
            data: {
                merk: $('#barang').val()
            },
            success: function(response){
                let data = response.data;
                let totalx = 0;
                let totalx2 = 0;
                let totaly = 0;
                let totaly2 = 0;
                let totalxy = 0;
                data.forEach((item) => {
                    $('#penjualan table tbody').append(`
                        <tr class="text-center">
                            <td>`+item['bulan'] +`</td>
                            <td>`+item['no'] +`</td>
                            <td>`+item['penjualan'] +`</td>
                            <td>`+item['no'] * item['no']+`</td>
                            <td>`+item['penjualan']*item['penjualan'] +`</td>
                            <td>`+item['no']*item['penjualan'] +`</td>
                        </tr>
                    `)
                    totalx += item['no'];
                    totalx2 += item['no'] * item['no'];
                    totaly += item['penjualan'];
                    totaly2 += item['penjualan'] * item['penjualan'];
                    totalxy += item['no'] * item['penjualan'];
                });
                
                $('#penjualan table tbody').append(`
                    <tr class="text-center">
                        <td> <strong>Total </strong></td>
                        <td> <strong>`+totalx+` </strong></td>
                        <td> <strong>`+totaly+` </strong></td>
                        <td> <strong>`+totalx2+` </strong></td>
                        <td> <strong>`+totaly2+` </strong></td>
                        <td> <strong>`+totalxy+` </strong></td>
                    </tr>
                `)
            }
        });
    }
</script>
@endpush