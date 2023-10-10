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
                            <li class="breadcrumb-item"><a href="#">Moltran</a></li>
                            <li class="breadcrumb-item"><a href="#">Elements</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h3 class="card-title text-white">Data Barang</h3>
                    </div>
                    <div class="card-body">
                        <select name="barang" id="barang" class="form-control">
                            <option selected disabled>Pilih barang</option>
                            @foreach ($barang as $b)
                                <option value="{{ $b->id }}">{{ $b->nama_barang }}</option>
                            @endforeach
                        </select>
                        <div class="d-flex justify-content-end mt-3">
                            <button class="btn btn-primary" id="tambah">Tambah barang</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-dark">
                        <h3 class="card-title text-white">List pembelian barang</h3>
                    </div>
                    <div class="card-body">
                        <form class="form-pembelian">
                            <input type="hidden" id="idbarang">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0" id="tabel-barang">
                                    <thead>
                                        <tr>
                                            <th width="10%"><a href="#" class="btn-remove"><i class="mdi mdi mdi-delete"></i></a></th>
                                            <th width="30%">Barang</th>
                                            <th width="20%">Harga</th>
                                            <th width="20%">Jumlah</th>
                                            <th width="20%">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot style="display:none">
                                        <tr>
                                            <td colspan="4">Total</td>
                                            <td class="grand-total">Rp. </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </form>
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
       
        function sweetAlert(icon, title) {
            Swal.fire({
                icon: icon,
                title: title,
            });
        }

        $(document).ready(() => {

            let arrayBarang = [];

            function removeall(){
                arrayBarang = [];
                $('.form-pembelian table tbody').html('');
                $('.grand-total').html('');
                $('.form-pembelian table tfoot').hide();
                countGrandTotal();
            }

            function countGrandTotal() {
                let grand_total = 0;
                arrayBarang.forEach(val => grand_total = grand_total + parseInt(val.total));
                if (grand_total <= 0) return $('.form-pembelian table tfoot').hide();
                $('.grand-total').html('<h4>Rp.'+rupiah(grand_total)+'</h4><input type="hidden" name="grand_total" value="'+grand_total+'">')
            }

            $(document).on('click', '#tambah', function(e) {
                e.preventDefault();
                let id = $('#barang').val();
                if (!id) return alert('belum dipilih');
                if (arrayBarang.filter(item => item.id == id).length > 0) return alert("sudah ada");

                $.ajax({
                    type: "GET",
                    url: "/get_barang/" + id,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function(response) {
                        console.log(response);
                        let html =
                            '<tr id="'+response.data.id+'">\
                                <td><a data-id="'+response.data.id+'" type="button" class="action-icon remove-item"> <i class="mdi mdi-delete"></i></a></td>\
                                <td>'+response.data.nama_barang+'<input type="hidden" name="nama_barang_id[]" value="'+response.data.barang_id+'"></td>\
                                <td>Rp. '+rupiah(response.data.harga_jual)+'<input type="hidden" name="harga[]" value="'+response.data.harga_jual+'"></td>\
                                <td><input type="number" name="jumlah[]" id="jumlah" data-harga_jual="'+response.data.harga_jual+'" data-id="'+response.data.id+'" class="form-control jumlah" value="1" max="'+response.data.jumlah+'" min="1"></td>\
                                <td>Rp. '+rupiah(response.data.harga_jual)+'</td>\
                            </tr>';
                        arrayBarang.push({
                            id: response.data.id,
                            jumlah: 1,
                            total: response.data.harga_jual
                        });
                        let grand_total = 0;
                        arrayBarang.forEach(val => grand_total = grand_total + parseInt(val.total));
                        $('.form-pembelian table tbody').append(html);
                        $('tfoot').show();
                        $('.grand-total').html('<h4>Rp. '+rupiah(grand_total)+'</h4> <input type="hidden" name="grand_total" value="'+grand_total+'">');
                        $('.form-pembelian #idbarang').val(JSON.stringify(arrayBarang));
                    }
                });
            });

            $(document).on('change', '.jumlah', function() {
                let id = $(this).data('id');
                let jumlah = $(this).val();
                let harga_jual = $(this).data('harga_jual');
                let total = jumlah * harga_jual;
                $('.form-pembelian #' + id + ' td:last').html('Rp.' + rupiah(total));
                objIndex = arrayBarang.findIndex((obj => obj.id == id));
                arrayBarang[objIndex].jumlah = jumlah;
                arrayBarang[objIndex].total = total;
                countGrandTotal();
            });

            $('.form-pembelian table').on('click', '.btn-remove', function() {
                if (arrayBarang.length == 0) return alert('tidak ada barang');
                arrayBarang = [];
                removeall();
            });

            $('.form-pembelian table').on('click', '.remove-item', function() {
                if (arrayBarang.length == 0) return alert('Belum ada item obat dipilih!');
                $(this).parent().parent().remove();
                let id = $(this).data('id');
                arrayBarang = arrayBarang.filter(e => e.id != id);
                $('.form-pembelian').val(JSON.stringify(arrayBarang));
                countGrandTotal();
            });

            $('.form-pembelian').on('submit', function(e){
                e.preventDefault();
                $('#save_tera').addClass('disabled');
                    $('#save_tera').html(`<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...`);
                    $.ajax({
                        url: "/",
                        method: "POST",
                        data: new FormData(this),
                        dataType:'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(response) {
                            console.log(response);
                            if (response.status == 401) {
                                sweetAlert('warning', response.errors);
                                $('#save_tera').removeClass('disabled');
                                $('#save_tera').html('Simpan Data Tera');
                            } else {
                                $('.input').removeClass('is-invalid');
                                $('#save_tera').removeClass('disabled');
                                $('#save_tera').html('Simpan Data Tera');
                                sweetAlert('success', response.message);
                                removeall();
                                document.getElementById("skhp").checked = false;
                                $('#jumlah_skhp').val(null);
                            }
                        }
                    });
            });
        });
    </script>
@endpush