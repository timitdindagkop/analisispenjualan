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
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Data barang</h3>
                            <button class="btn btn-primary" id="tambah-barang">+ Tambah barang</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-12">
                                <table id="data-barang" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="10%">Suplier</th>
                                            <th width="20%">Nama barang</th>
                                            <th width="20%">Harga Kiloan</th>
                                            <th width="10%">Stok</th>
                                            <th width="25%">Keterangan</th>
                                            <th width="10%">#</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
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
    @include('master.barang.modal_input')
@endsection
@push('js')
    
    <!-- third party js -->
    <script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="/assets/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="/assets/libs/datatables/responsive.bootstrap4.min.js"></script>
    <script>
        var harga_beli = document.getElementById("harga_beli");
        harga_beli.addEventListener("keyup", function(e) {
            harga_beli.value = convertRupiah(this.value, "Rp. ");
        });
        
        var harga_jual = document.getElementById("harga_jual");
        harga_jual.addEventListener("keyup", function(e) {
            harga_jual.value = convertRupiah(this.value, "Rp. ");
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

        const rupiah = (number) => {
            return new Intl.NumberFormat("id-ID", {
            style: "decimal",
            currency: "IDR"
            }).format(number);
        }

        // load data table
        const table = $('#data-barang').DataTable({          
            "lengthMenu": [[5, 10, 25, 50, 100, -1],[5, 10, 25, 50, 100, 'All']],
            "pageLength": 10, 
            processing: true,
            serverSide: true,
            responseive: true,
            ajax: {
                url:"{{ url('json_b') }}",
                type:"POST",
                data:function(d){
                    d._token = "{{ csrf_token() }}"
                }
            },
            columns:[
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return row.suplier.nama_perusahaan
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return row.kode_barang+` - `+row.nama_barang
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return `Harga Jual : Rp. `+rupiah(row.harga_jual)+ `<br />Harga Beli : Rp. `+rupiah(row.harga_beli)
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return row.stok_barang
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return row.keterangan
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return `
                        <div class="btn-group">
                            <button class="btn btn-sm btn-warning edit-barang" title="Edit data" data-id="`+row.id+`"><i class="mdi mdi mdi-file-document-edit-outline"></i></button>
                            <button class="btn btn-sm btn-danger hapusdata" title="Hapus data" data-id="`+row.id+`"><i class="mdi mdi mdi-delete-outline"></i></button>
                        </div>
                    `
                    }
                },
            ]
        });

        $(document).on('click', '#tambah-barang', function(e){
            $('#judul_modal').text("Tambah data barang");
            $('#modal_input').modal('show');
            $('#simpan').val('save');
            $('#simpan').text("Simpan Data");
            $('.input').removeClass('is-invalid');
            document.getElementById("form_input").reset();
        });

        $(document).on('click', '.edit-barang', function(e){
            $('#judul_modal').text("Edit data barang");
            $('.input').removeClass('is-invalid');
            let idedit = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "{{ route('b.index') }}/"+ idedit,
                success: function(response){
                    $('#simpan').val("update");
                    $('#simpan').text("Ubah Data");
                    $('#id').val(response.data.id);
                    $('#nama_barang').val(response.data.nama_barang);
                    $('#kode_barang').val(response.data.kode_barang);
                    $('#suplier_id').val(response.data.suplier_id);
                    harga_beli.value = convertRupiah(response.data.harga_beli, "Rp. ");
                    harga_jual.value = convertRupiah(response.data.harga_jual, "Rp. ");
                    $('#stok_barang').val(response.data.stok_barang);
                    $('#keterangan').val(response.data.keterangan);
                    $('#modal_input').modal('show');
                },
                error: function(err){
                    Swal.fire({
                        type:"error",
                        title:"Maaf...",
                        text: err.responseJSON.message,
                        confirmButtonColor:"#348cd4",
                    });
                }
            })
        })

        // untuk menyimpan ataupun mengubah data
        $(document).on('click', '#simpan', function(e){
            $('.input').removeClass('is-invalid');
            let url = "";
            let type = "";
            if($(this).val() == 'save'){
                url = "{{ route('b.index') }}"
                type = "POST";
            }
            if($(this).val() == 'update'){
                let idupdate = $("#id").val();
                url = "{{ route('b.index') }}/"+idupdate;
                type = "PATCH";
            }
            $.ajax({
                type: type,
                url: url,
                data: $("#form_input").serialize(),
                dataType: 'json',
                success: function(response){
                    Swal.fire({title:"Selamat!",text:response.message,type:"success",confirmButtonColor:"#348cd4"})
                    table.ajax.reload();
                    document.getElementById("form_input").reset();
                    $('#modal_input').modal('hide');
                },
                error: function(err) {
                    let error = err.responseJSON;
                    $.each(error.errors, function(key, value){
                        $('#'+key).addClass('is-invalid');
                    })
                }
            })
        });

        // belum fix
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
                        url: "{{ route('b.index') }}/" + idhapus,
                        data: {'_token': '{{ csrf_token() }}'},
                        dataType: 'json',
                        success: function(response) {
                            Swal.fire("Deleted!",response.message,"success")
                            table.ajax.reload();
                        }
                    });

                }
            })
        });
    </script>
@endpush