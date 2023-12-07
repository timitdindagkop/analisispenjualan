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
                            <li class="breadcrumb-item"><a href="#">Pembelian</a></li>
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
                    <div class="card-header bg-secondary">
                        <h3 class="card-title text-white">Data Suplier</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 info-suplier" style="display: none">
                                <div class="isi-suplier"></div>
                                <button class="btn btn-lg btn-danger ubah-suplier">Ubah pilihan suplier</button>
                            </div>
                            <div class="col-lg-12 card-suplier">
                                <select name="suplier" id="suplier" class="form-control">
                                    <option selected disabled>Pilih Suplier</option>
                                    @foreach ($suplier as $s)
                                        <option value="{{ $s->id }}">{{ $s->nama_perusahaan }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-lg btn-dark mt-2" id="pilih-suplier">Pilih Suplier</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h3 class="card-title text-white">Data Barang</h3>
                    </div>
                    <div class="card-body">
                        <select name="barang" id="barang" class="form-control">
                            <option selected disabled>Pilih barang</option>
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
                        <form id="form-pembelian">
                            @csrf
                            <input type="hidden" id="idbarang">
                            <input type="hidden" id="suplier_id" name="suplier_id">
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
                                            <td colspan="4"><h4>Total</h4></td>
                                            <td class="grand-total">Rp. </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-lg btn-success" id="tombol-simpan" style="display:none">+ Simpan pembelian</button>
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
    <script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>
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
                $('#form-pembelian table tbody').html('');
                $('.grand-total').html('');
                $('#form-pembelian table tfoot').hide();
                $('#tombol-simpan').hide();
                countGrandTotal();
            }

            function countGrandTotal() {
                let grand_total = 0;
                let jumlah_total = 0;
                arrayBarang.forEach(gt => grand_total = grand_total + parseInt(gt.total));
                arrayBarang.forEach(jt => jumlah_total = jumlah_total + parseInt(jt.jumlah));
                if (grand_total <= 0) return $('#form-pembelian table tfoot').hide();
                $('.grand-total').html('<h4>Rp.'+rupiah(grand_total)+'</h4><input type="hidden" name="grand_total" value="'+grand_total+'"><input type="hidden" name="jumlah_total" value="'+jumlah_total+'">')
            }

            $(document).on('click', '#pilih-suplier', function(e){
                // if(!this.value) return alert('Mohon pilih suplier');
                e.preventDefault();
                $('#barang').empty();
                $('#barang').append('<option selected disabled>Pilih barang</option>');
                let suplierid = $('#suplier').val();
                $.ajax({
                    type: "GET",
                    url: "{{ url('get_lb') }}/"+suplierid,
                    data: {'_token': '{{ csrf_token() }}'},
                    success: function(response){
                        if(response.status == 200) {
                            var barang = response.data;
                            barang.forEach(function(item){$('#barang').append(`<option value="`+item.id+`">`+item.nama_barang+`</option>`)});
                            $('#suplier_id').val(suplierid);
                            $('.info-suplier').show();
                            $('.card-suplier').hide();
                            $('.isi-suplier').html(`<h4>`+response.suplier.nama_perusahaan+` (`+response.suplier.kode_perusahaan+`)</h4>`);
                        }
                    },
                    error: function(err){
                        alert(err.messageJSON.message);
                    }
                });
            });

            $(document).on('click', '.ubah-suplier', function(e){
                $('.card-suplier').show();
                $('.info-suplier').hide();
                $('#barang').empty();
                $('#barang').append('<option selected disabled>Pilih barang</option>');
                arrayBarang = [];
                removeall();
            });

            $(document).on('click', '#tambah', function(e) {
                e.preventDefault();
                let id = $('#barang').val();
                if (!id) return alert('belum dipilih');
                if (arrayBarang.filter(item => item.id == id).length > 0) return alert("sudah ada");

                $.ajax({
                    type: "GET",
                    url: "{{ route('b.index') }}/" + id,
                    data: {'_token': '{{ csrf_token() }}'},
                    success: function(response) {
                        let html =
                            '<tr id="'+response.data.id+'">\
                                <td><a data-id="'+response.data.id+'" type="button" class="action-icon remove-item"> <i class="mdi mdi-delete"></i></a></td>\
                                <td>'+response.data.nama_barang+'<input type="hidden" name="barang_id[]" value="'+response.data.id+'"></td>\
                                <td>Rp. '+rupiah(response.data.harga_beli)+'<input type="hidden" name="harga[]" value="'+response.data.harga_beli+'"></td>\
                                <td><input type="number" name="jumlah[]" id="jumlah" data-harga_beli="'+response.data.harga_beli+'" data-id="'+response.data.id+'" class="form-control jumlah" value="1" max="'+response.data.jumlah+'" min="1"></td>\
                                <td>Rp. '+rupiah(response.data.harga_beli)+'</td>\
                            </tr>';
                        arrayBarang.push({
                            id: response.data.id,
                            jumlah: 1,
                            total: response.data.harga_beli
                        });
                        let grand_total = 0;
                        let jumlah_total = 0;
                        arrayBarang.forEach(gt => grand_total = grand_total + parseInt(gt.total));
                        arrayBarang.forEach(jt => jumlah_total = jumlah_total + parseInt(jt.jumlah));
                        $('#form-pembelian table tbody').append(html);
                        $('.grand-total').html('<h4>Rp. '+rupiah(grand_total)+'</h4> <input type="hidden" name="grand_total" value="'+grand_total+'"><input type="hidden" name="jumlah_total" value="'+jumlah_total+'">');
                        $('#form-pembelian #idbarang').val(JSON.stringify(arrayBarang));
                        $('tfoot').show();
                        $('#tombol-simpan').show();
                    }
                });
            });

            $(document).on('change', '.jumlah', function() {
                let id = $(this).data('id');
                let jumlah = $(this).val();
                let harga_beli = $(this).data('harga_beli');
                let total = jumlah * harga_beli;
                $('#form-pembelian #' + id + ' td:last').html('Rp.' + rupiah(total));
                objIndex = arrayBarang.findIndex((obj => obj.id == id));
                arrayBarang[objIndex].jumlah = jumlah;
                arrayBarang[objIndex].total = total;
                countGrandTotal();
            });

            $('#form-pembelian table').on('click', '.btn-remove', function() {
                if (arrayBarang.length == 0) return alert('tidak ada barang');
                arrayBarang = [];
                removeall();
            });

            $('#form-pembelian table').on('click', '.remove-item', function() {
                if (arrayBarang.length == 0) return alert('Belum ada item obat dipilih!');
                $(this).parent().parent().remove();
                let id = $(this).data('id');
                arrayBarang = arrayBarang.filter(e => e.id != id);
                $('#form-pembelian').val(JSON.stringify(arrayBarang));
                countGrandTotal();
            });

            $('#form-pembelian').on('submit', function(e) {
                e.preventDefault();
                $('#tombol-simpan').addClass('disabled');
                $('#tombol-simpan').html(`<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...`);
                $.ajax({
                    url: "{{ route('pb.index') }}",
                    type: "POST",
                    data: $('#form-pembelian').serialize(),
                    dataType: "json",
                    success: function(response) {
                        removeall()
                        Swal.fire({title:"Selamat!",text:response.message,type:"success",confirmButtonColor:"#348cd4"});
                        $('.card-suplier').show();
                        $('.info-suplier').hide();
                        $('#barang').empty();
                        $('#barang').append('<option selected disabled>Pilih barang</option>');
                        $('#suplier').val("Pilih Suplier");
                    }
                });
            });
        });
    </script>
@endpush