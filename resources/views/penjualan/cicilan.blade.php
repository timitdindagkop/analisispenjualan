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
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h5 class="text-white">Data Pembelian</h5>
                    </div>
                    <div class="card-body">
                        Pembeli : {{ $data->Pembeli->nama_pembeli }}<br />
                        Tanggal : {{ date('d/m/Y', strtotime($data->tanggal)) }}<br />
                        Total jumlah barang : {{ $data->total_barang }} Kilo<br />
                        Total harus bayar : Rp. {{ number_format($data->total_uang,0,',','.') }}<br />
                        <hr />
                        Status Cicilan : <span class="badge badge-primary">{{ $data->status_cicilan }}</span> <br />
                        Total Cicilan : {{ $data->jumlah_cicilan }} Kali<br />
                        DP Cicilan : Rp. {{ number_format($data->dp_cicilan,0,',','.') }}<br />
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5>Daftar Cicilan</h5>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama barang</th>
                                                <th>Jumlah</th>
                                                <th>Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($detail as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->barang->nama_barang }}</td>
                                                    <td>{{ $item->jumlah }} Kilo</td>
                                                    <td>Rp. {{ number_format($item->harga,0,',','.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <h5>Daftar Barang dibeli</h5>
                            <button class="btn btn-sm btn-success">Bayar cicilan</button>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive" id="cicilan">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr class="text-center">
                                                <th>#</th>
                                                <th>Cicilan ke</th>
                                                <th>Jumlah Uang</th>
                                                <th>Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="4" class="text-center" id="loading">
                                                    <div class="spinner-border text-info m-1" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

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

        $(document).ready(function () {
            loaddata()
        });

        function loaddata() {
            let data = {'bulan': $('#bulan').val()}
            $.ajax({
                type: "GET",
                data: data,
                url: "{{ url('get_c') }}/"+"{{ $data->id }}",
                success: function (response){
                    let data = response.data;
                    $('#loading').hide()
                    if (data.length < 0) {
                        body = `
                        <tr class="text-center">
                            <td colspan="4">Belum ada cicilan</td>
                        </tr>`
                        $('#cicilan table tbody').append(body); 
                    } else {
                        let no = 1
                        let body = ''
                        data.forEach((params) => {
                            let tanggal = params.created_at;
                            var hari = tanggal.substring(8,10)
                            var bulan = tanggal.substring(7,5)
                            var tahun = tanggal.substring(0,4)
                            body = `
                            <tr class="text-center">
                                <td>`+no+`</td>
                                <td>`+params.urutan_cicilan+`</td>
                                <td>`+rupiah(params.jumlah_uang)+`</td>
                                <td>`+hari+`/`+bulan+`/`+tahun+`</td>
                            </tr>`
                            $('#cicilan table tbody').append(body);
                            no++
                        });    
                    }
                }
            });
        }
    </script>
@endpush