@extends('layout.main')
@push('css')
    <link href="/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
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
                        Status Cicilan : <span class="badge badge-primary status">{{ $data->status_cicilan }}</span> <br />
                        DP Cicilan : Rp. {{ number_format($data->dp_cicilan,0,',','.') }}<br />
                        Cicilan : <span id="jumlah_cicilan">Rp. 0</span> <br />
                        Kekurangan uang : <span id="kekurangan_uang">Rp. 0</span>
                        <input type="hidden" id="uang" name="uang">
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5>Daftar barang yang dibeli</h5>
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
                            <h5>Daftar cicilan</h5>
                            <button class="btn btn-sm btn-success bayar_cicilan" data-toggle="modal" data-target="#modalcicilan">Bayar cicilan</button>
                            <button class="btn btn-sm btn-dark bayar_cicilan2" style="display: none" disabled>Bayar cicilan</button>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive" id="cicilan">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr class="text-center">
                                                <th width="15%">Cicilan ke</th>
                                                <th width="40%">Jumlah Uang</th>
                                                <th width="35%">Tanggal</th>
                                                <th width="10%">#</th>
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
    @include('penjualan.modal_cicilan')
@endsection

@push('js')
    <script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>
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

        var jumlah_uang = document.getElementById("jumlah_uang");
        jumlah_uang.addEventListener("keyup", function(e) {
            jumlah_uang.value = convertRupiah(this.value, "Rp. ");
        });

        function convertRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? prefix + rupiah : "";
        }

        function loaddata() {
            $.ajax({
                type: "GET",
                url: "{{ url('get_c') }}/"+"{{ $data->id }}",
                success: function (response){
                    if (response.kekurangan_uang == 0) {
                        $('.bayar_cicilan').hide();
                        $('.bayar_cicilan2').show();
                        $('.status').removeClass('badge-primary');
                        $('.status').addClass('badge-success');
                        $('.status').html('Lunas');
                    }

                    $('#jumlah_cicilan').text("Rp. "+rupiah(response.cicilan));
                    $('#kekurangan_uang').text("Rp. "+rupiah(response.kekurangan_uang));
                    $('#uang').val(response.kekurangan_uang);

                    let data = response.data;
                    let body = '';
                    $('#loading').hide()
                    $('#cicilan table tbody').html('');
                    if (data.length <= 0) {
                        body = `
                        <tr class="text-center">
                            <td colspan="4">Belum ada cicilan</td>
                        </tr>`
                        $('#cicilan table tbody').html(body); 
                    } else {
                        body = ''
                        data.forEach((params) => {
                            let tanggal = params.created_at;
                            var hari = tanggal.substring(8,10)
                            var bulan = tanggal.substring(7,5)
                            var tahun = tanggal.substring(0,4)
                            body = `
                            <tr class="text-center">
                                <td>`+params.urutan_cicilan+`</td>
                                <td>`+rupiah(params.jumlah_uang)+`</td>
                                <td>`+hari+`/`+bulan+`/`+tahun+`</td>
                                <td><a class="btn btn-sm btn-danger text-white hapusdata" data-id="`+params.id+`">Hapus</a></td>
                            </tr>`
                            $('#cicilan table tbody').append(body);
                        });    
                    }
                }
            });
        }

        $('#form_cicilan').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: "{{ url('store_cicilan') }}",
                method: "POST",
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    $('#modalcicilan').modal('hide');
                    $('#jumlah_uang').val("");
                    loaddata();
                    console.log(response);
                }, 
                error: function(err){
                    Swal.fire({title:"Mohon maaf!",text:"Cicilan tidak berhasil di input, pastikan data nominal yang diisi dengan benar",type:"warning",confirmButtonColor:"#348cd4"})
                console.log(err);    
                }
            });
        });

        $(document).on('click', '.hapusdata', function(e) {
            let idhapus = $(this).data('id');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda akan menghapus data ini!",
                type: 'warning',
                showCancelButton:!0,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('/del_cicilan') }}/" + idhapus,
                        data: {'_token': '{{ csrf_token() }}'},
                        dataType: 'json',
                        success: function(response) {
                            Swal.fire("Deleted!",response.message,"success")
                            loaddata();
                        }
                    });

                }
            })
        });
    </script>
@endpush