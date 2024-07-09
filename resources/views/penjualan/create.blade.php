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

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h3 class="card-title text-white">Data Barang</h3>
                    </div>
                    <div class="card-body">
                        <select name="pembeli" id="pembeli" class="form-control pembelis">
                            <option selected disabled>Pilih pembeli</option>
                            @foreach ($pembeli as $s)
                                <option value="{{ $s->id }}">{{ $s->nama_pembeli }}</option>
                            @endforeach
                        </select>

                        <div class="d-flex justify-content-end mb-3">
                            <button class="btn btn-dark mt-2" id="pilih-pembeli">Pilih pembeli</button>
                            <button class="btn btn-danger mt-2" id="ubah-pembeli" style="display: none">Ubah Pembeli</button>
                        </div>



                        <select name="barang" id="barang" class="form-control barangs" disabled>
                            <option selected disabled>Pilih barang</option>
                            @foreach ($barang as $b)
                                <option value="{{ $b->id }}">{{ $b->nama_barang }}</option>
                            @endforeach
                        </select>
                        <div class="d-flex justify-content-end mt-3">
                            <button class="btn btn-primary barangs" id="tambah" disabled>Tambah barang</button>
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
                            <input type="hidden" id="pembeli_id" name="pembeli_id">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0" id="tabel-barang">
                                    <thead>
                                        <tr>
                                            <th width="10%"><a href="#" class="btn-remove"><i class="mdi mdi mdi-delete"></i></a></th>
                                            <th width="30%">Barang</th>
                                            <th width="20%">Harga</th>
                                            <th width="20%">Berat (Kg)</th>
                                            <th width="20%">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4"><h4>Total</h4></td>
                                            <td class="grand-total">Rp. 0</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-8">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="cicilan" name="cicilan" value="ya">
                                        <label class="form-check-label" for="cicilan">Ada cicilan ?</label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="dp_cicilan" id="dp_cicilan" placeholder="Masukan DP cicilan" value="Rp. 0" readonly>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="row" id="tanggal_status">
                                    <div class="col-12">
                                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-6">
                                        {{-- <select name="status_bayar" id="status_bayar" class="form-control">
                                            <option value="Belum lunas">Belum lunas</option>    
                                            <option value="Lunas">Lunas</option>    
                                        </select>     --}}
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-lg btn-success" id="tombol-simpan" disabled>+ Simpan penjualan</button>
                                <a href="" class="btn btn-lg btn-dark" id="cetak" target="_blank" style="display: none">Cetak nota</a>
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

        var dp_cicil = document.getElementById("dp_cicilan");
        dp_cicil.addEventListener("keyup", function(e) {
            $('#dp_cicilan').removeClass("is-invalid");
            dp_cicil.value = convertRupiah(this.value, "Rp. ");
        });

        // membuat format rupiah
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

        $(document).ready(() => {

            let arrayBarang = [];

            function removeall(){
                arrayBarang = [];
                $('#form-pembelian table tbody').html('');
                $('.grand-total').html('');
                // $('#form-pembelian table tfoot').hide();
                countGrandTotal();
            }

            function countGrandTotal() {
                let grand_total = 0;
                let jumlah_total = 0;
                arrayBarang.forEach(gt => grand_total = grand_total + parseInt(gt.total));
                arrayBarang.forEach(jt => jumlah_total = jumlah_total + parseInt(jt.jumlah));
                // if (grand_total <= 0) return $('#form-pembelian table tfoot').hide();
                $('.grand-total').html('<h4>Rp. '+rupiah(grand_total)+'</h4><input type="hidden" name="grand_total" value="'+grand_total+'"><input type="hidden" name="jumlah_total" value="'+jumlah_total+'">')
            }

            $(document).on('click', '#pilih-pembeli',function(e){
                
                // mengambil data select pembeli
                // $('#dp_cicilan').val(dp_cicil.replace(/[^0-9\.]/g,''));
                // let pembeli = document.getElementById("pembeli");
                // let v_pembeli = pembeli.value;
                // let t_pembeli = pembeli.options[pembeli.selectedIndex].text;
                
                let pembeliid = $('#pembeli').val();
                if(!pembeliid) return alert('Mohon pilih pembeli');
                $('#pembeli_id').val(pembeliid);
                $('#pilih-pembeli').hide();
                $('#ubah-pembeli').show();
                $('.pembelis').attr("disabled", true);
                $('.barangs').attr("disabled", false);
                $('#tombol-simpan').attr("disabled", false);
            });

            $(document).on('click', '#ubah-pembeli', function(e){
                $('#pilih-pembeli').show();
                $('#ubah-pembeli').hide();
                $('#barang').val('Pilih barang');
                $('#pembeli').val('Pilih pembeli');
                $('#cicilan').prop("checked", false);
                $('#pembeli_id').val(null);
                $('#status_cicilan').val(null);
                $('#dp_cicilan').val(null);
                $('.pembelis').attr('disabled', false);
                $('.barangs').attr('disabled', true);
                arrayBarang = [];
                removeall();
            });

            $(document).on('click', '#cicilan', function(e){
                var cek = $('input[name="cicilan"]:checked');
                if (cek.length > 0) {
                    $('#dp_cicilan').val('')
                    $('#dp_cicilan').attr("readonly", false);                    
                    } else {
                    $('#dp_cicilan').val('Rp. 0')
                    $('#dp_cicilan').attr("readonly", true);
                }
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
                                <td>Rp. '+rupiah(response.data.harga_jual)+'<input type="hidden" name="harga[]" value="'+response.data.harga_jual+'"></td>\
                                <td><input type="number" name="jumlah[]" id="jumlah" data-stok_barang="'+response.data.stok_barang+'" data-harga_jual="'+response.data.harga_jual+'" data-id="'+response.data.id+'" class="form-control jumlah" value="1" max="'+response.data.jumlah+'" min="1"></td>\
                                <td>Rp. '+rupiah(response.data.harga_jual)+'</td>\
                            </tr>';
                        arrayBarang.push({
                            id: response.data.id,
                            jumlah: 1,
                            total: response.data.harga_jual
                        });
                        let grand_total = 0;
                        let jumlah_total = 0;
                        arrayBarang.forEach(gt => grand_total = grand_total + parseInt(gt.total));
                        arrayBarang.forEach(jt => jumlah_total = jumlah_total + parseInt(jt.jumlah));
                        $('#form-pembelian table tbody').append(html);
                        $('.grand-total').html('<h4>Rp. '+rupiah(grand_total)+'</h4> <input type="hidden" name="grand_total" value="'+grand_total+'"><input type="hidden" name="jumlah_total" value="'+jumlah_total+'">');
                        $('#form-pembelian #idbarang').val(JSON.stringify(arrayBarang));
                        $('tfoot').show();
                        $('#tanggalandsimpan').show();
                    }
                });
            });

            $(document).on('change', '.jumlah', function() {
                
                let id = $(this).data('id');
                let jumlah = $(this).val();
                let harga_jual = $(this).data('harga_jual');
                let stok_barang = $(this).data('stok_barang');
                let total = jumlah * harga_jual;
                var a = parseInt(stok_barang);
                var b = parseInt(jumlah);
                if (a < b) {
                    alert("Permintaan melebihi stok barang");     
                    $(this).val(stok_barang)    
                }
                $('#form-pembelian #' + id + ' td:last').html('Rp. ' + rupiah(total));
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
                $('#tombol-simpan').attr('disabled', true);
                $('#tombol-simpan').html(`<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...`);
                $.ajax({
                    url: "{{ route('pj.index') }}",
                    type: "POST",
                    data: $('#form-pembelian').serialize(),
                    dataType: "json",
                    success: function(response) {
                        removeall()
                        console.log(response);
                        Swal.fire({title:"Selamat!",text:response.message,type:"success",confirmButtonColor:"#348cd4"});
                        $('#dp_cicilan').val('Rp. 0');
                        $('#barang').val('Pilih barang');
                        $('#pembeli').val("Pilih pembeli");
                        $('.barangs').attr('disabled', true);
                        $('.pembelis').attr('disabled', false);
                        $('#dp_cicilan').attr("readonly", true);
                        $('#cicilan').prop("checked", false);
                        $('#tombol-simpan').html('+ Simpan penjualan');
                        $('#tombol-simpan').hide();
                        $('#cetak').show();
                        $('#cetak').prop("href", "/print_pj/"+ response.idpenjualan);
                    }
                });
            });
        });
    </script>
@endpush