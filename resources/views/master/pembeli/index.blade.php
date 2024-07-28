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
                            <h3 class="card-title">Data Pembeli</h3>
                            <button class="btn btn-primary" id="tambah-pembeli">+ Tambah Pembeli</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-12">
                                <table id="data-pembeli" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="20%">Kode</th>
                                            <th width="20%">Nama Pembeli</th>
                                            <th width="15%">Telepon</th>
                                            <th width="30%">Alamat</th>
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
    @include('master.pembeli.modal_input')
@endsection
@push('js')
    
    <!-- third party js -->
    <script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="/assets/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="/assets/libs/datatables/responsive.bootstrap4.min.js"></script>
    
    <script>

        // load data table
        const table = $('#data-pembeli').DataTable({          
            "lengthMenu": [[5, 10, 25, 50, 100, -1],[5, 10, 25, 50, 100, 'All']],
            "pageLength": 10, 
            processing: true,
            serverSide: true,
            responseive: true,
            ajax: {
                url:"{{ url('json_pe') }}",
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
                    return row.kode_pembeli
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return row.nama_pembeli
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return row.telepon
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return row.alamat
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return `
                        <div class="btn-group">
                            <button class="btn btn-sm btn-warning edit-pembeli" title="Edit data" data-id="`+row.id+`"><i class="mdi mdi mdi-file-document-edit-outline"></i></button>
                            <button class="btn btn-sm btn-danger hapusdata" title="Hapus data" data-id="`+row.id+`"><i class="mdi mdi mdi-delete-outline"></i></button>
                        </div>
                    `
                    }
                },
            ]
        });

        $(document).on('click', '#tambah-pembeli', function(e){
            $('#judul_modal').text("Tambah data pembeli");
            $('#modal_input').modal('show');
            $('#simpan').val('save');
            $('#simpan').text("Simpan Data");
            $('.input').removeClass('is-invalid');
            document.getElementById("form_input").reset();
        });

        $(document).on('click', '.edit-pembeli', function(e){
            $('#judul_modal').text("Edit data pembeli");
            $('.input').removeClass('is-invalid');
            let idedit = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "{{ route('pe.index') }}/"+ idedit,
                success: function(response){
                    $('#simpan').val("update");
                    $('#simpan').text("Ubah Data");
                    $('#id').val(response.data.id);
                    $('#nama_pembeli').val(response.data.nama_pembeli);
                    $('#alamat').val(response.data.alamat);
                    $('#telepon').val(response.data.telepon);
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

        $(document).on('click', '#simpan', function(e){
            $('.input').removeClass('is-invalid');
            let url = "";
            let type = "";
            if($(this).val() == 'save'){
                url = "{{ route('pe.index') }}"
                type = "POST";
            }
            if($(this).val() == 'update'){
                let idupdate = $("#id").val();
                url = "{{ route('pe.index') }}/"+idupdate;
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
                        $('#err'+key).text(value);
                        $('#err'+key).addClass('text-danger');
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
                        url: "{{ route('pe.index') }}/" + idhapus,
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