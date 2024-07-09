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
                        <h3 class="card-title">Data pembelian</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-12">
                                <table id="data-pembelianbarang" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            {{-- <th width="15%">Kode Pembelian</th> --}}
                                            <th width="20%">Tanggal</th>
                                            <th width="30%">Total Barang (Kg)</th>
                                            <th width="30%">Total Uang</th>
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
    @include('pembelian.modal_detail')
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
        const table = $('#data-pembelianbarang').DataTable({          
            "lengthMenu": [[5, 10, 25, 50, 100, -1],[5, 10, 25, 50, 100, 'All']],
            "pageLength": 10, 
            processing: true,
            serverSide: true,
            responseive: true,
            ajax: {
                url:"{{ url('json_pb') }}",
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
                        var detail_html = "";
                        var nomor = 1;
                        if (Array.isArray(row.detail_pembelian_barang)) {
                            row.detail_pembelian_barang.forEach(function(detail){
                                detail_html += `Barang: ${nomor++}, Jumlah: ${detail.jumlah}<br>`;
                            });
                        } else {
                            detail_html = "No details available";
                        }
                        return detail_html;
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
                    return `<a href="#" class="btn btn-sm btn-primary detail" data-id="`+row.id+`">Detail</a>`;
                    }
                },
            ]
        });

        $(document).on('click', '.detail', function(e) {
            e.preventDefault();
            let iddetail = $(this).data('id');
            $.ajax({
                url: "{{ url('pb_detail') }}/" + iddetail,
                type: "GET",
                dataType: 'json',
                success: function(response) {
                    $('#modalDetail').modal('show');
                    $('#data-detail table tbody').html("");
                    let datadetail = response.data;
                    datadetail.forEach(function(detail) {
                        $('#data-detail table tbody').append(`
                            <tr>    
                                <td>${detail.barang.nama_barang}</td>
                                <td>Rp. ${rupiah(detail.harga)}</td>
                                <td>${detail.jumlah}</td>
                                <td>Rp. ${rupiah(detail.jumlah * detail.harga)}</td>
                            </tr>
                        `);
                    });
                }
            });
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
                        url: "{{ route('pb.index') }}/" + idhapus,
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