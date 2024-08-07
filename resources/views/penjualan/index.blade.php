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
                        <h3 class="card-title">Data penjualan</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-12">
                                <table id="data-penjualanbarang" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            {{-- <th width="15%">Kode Penjualan</th> --}}
                                            <th width="15%">Pembeli</th>
                                            <th width="15%">Tanggal</th>
                                            <th width="10%">Qty</th>
                                            <th width="15%">Total Uang</th>
                                            <th width="10%">Bayar</th>
                                            <th width="10%">Cicilan</th>
                                            <th width="5%">#</th>
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
@endsection
@push('js')
    
    <!-- third party js -->
    <script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="/assets/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="/assets/libs/datatables/responsive.bootstrap4.min.js"></script>
    <script>

        const rupiah = (number) => {
            return new Intl.NumberFormat("id-ID", {
            style: "decimal",
            currency: "IDR"
            }).format(number);
        }

        // load data table
        const table = $('#data-penjualanbarang').DataTable({          
            "lengthMenu": [[5, 10, 25, 50, 100, -1],[5, 10, 25, 50, 100, 'All']],
            "pageLength": 10, 
            processing: true,
            serverSide: true,
            responseive: true,
            ajax: {
                url:"{{ url('json_pj') }}",
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
                // {
                //     "targets": "_all",
                //     "defaultContent": "-",
                //     "render": function(data, type, row, meta){
                //     return row.id
                //     }
                // },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return row.nama
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        var tanggal = row.tanggal
                        var hari = tanggal.substring(8,10)
                        var bulan = tanggal.substring(7,5)
                        var tahun = tanggal.substring(0,4)
                        return hari+'/'+bulan+"/"+tahun
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return row.total_barang + " kilo"
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return 'Rp. '+rupiah(row.total_uang)
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return row.status_bayar
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return row.status_cicilan
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    if (row.status_cicilan == "ya" || row.status_cicilan == "Lunas") {
                        return `<a href="{{ route('pj.index') }}/`+row.id+`" class="btn btn-sm btn-primary">Cicilan</a>
                        <div class="btn-group">
                            <a href="{{ url('print_pj') }}/`+row.id+`" target="_blank" class="btn btn-sm btn-success edit-barang" title="Cetak laporan" data-id="`+row.id+`"><i class="mdi mdi mdi-printer"></i></a>
                        </div>
                    `
                    }else{
                        return `
                        <div class="btn-group">
                            <a href="{{ url('print_pj') }}/`+row.id+`" target="_blank" class="btn btn-sm btn-success edit-barang" title="Cetak laporan" data-id="`+row.id+`"><i class="mdi mdi mdi-printer"></i></a> 
                        </div>
                        `
                    }
                    

                    }
                },
            ]
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
                        url: "{{ route('pj.index') }}/" + idhapus,
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