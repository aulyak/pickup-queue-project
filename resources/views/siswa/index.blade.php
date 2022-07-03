@extends('adminlte::page')

@section('title', 'Data Siswa')

@section('content_header')

    &nbsp

@stop

@section('content')

    <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" action="/siswa/import_excel" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="file" name="file" required="required">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if (count($errors) > 0)
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Error!</h4>
                    @foreach ($errors->all() as $error)
                        {{ $error }} <br>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if (Session::has('success'))
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5>{!! Session::get('success') !!}</h5>
                </div>
            </div>
        </div>
    @endif

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm">
                                    <h2 class="text-left">Data Siswa</h2>
                                </div>
                                <div class="col-sm text-right">
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target="#importExcel">
                                        <i class="fa fa-file-excel"></i>
                                        Import
                                    </button>
                                    <a type="button" class="btn btn-primary" href="{{ route('siswa.create') }}">
                                        <i class="fa fa-plus-circle"></i>
                                        Tambah Siswa
                                    </a>
                                    {{-- <a type="button" style="margin-right:5px" class="btn btn-primary float-right">
                                        <i class="fa fa-filter"></i>
                                        Filter
                                    </a> --}}
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div id="table_siswa_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6"></div>
                                    <div class="col-sm-12 col-md-6"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="table_siswa"
                                            class="table table-bordered table-hover dataTable dtr-inline" role="grid"
                                            aria-describedby="table_siswa_info">
                                            <thead>
                                                <tr role="row">
                                                    <th></th>
                                                    <th>No.</th>
                                                    <th>NIS</th>
                                                    <th>Nama</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $key => $siswa)
                                                    <tr data-penjemput="{{ $siswa->penjemput }}">
                                                        <td class="dt-control text-center" style="cursor:pointer">
                                                            <i type="button" class="fa fa-plus-circle"></i>
                                                        </td>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $siswa->nis }}</td>
                                                        <td>{{ ucwords($siswa->nama_siswa) }}</td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a type="button" class="btn btn-info mr-1"
                                                                    href={{ route('siswa.show', ['siswa' => $siswa]) }}><i
                                                                        class="fa fa-eye"></i></a>
                                                                <a type="button" class="btn btn-success mr-1"
                                                                    href={{ route('siswa.edit', ['siswa' => $siswa]) }}><i
                                                                        class="fa fa-edit"></i></a>
                                                                <a type="button" class="btn btn-danger mr-1"
                                                                    onclick="notificationBeforeDelete(event, this)"
                                                                    href="{{ route('siswa.setInactive', ['siswa' => $siswa]) }}"><i
                                                                        class="fa fa-trash"></i></a>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@stop

@section('css')

@stop

@section('js')
    <form action="" id="delete-form" method="post">
        @method('put')
        @csrf
    </form>
    <script>
        function notificationBeforeDelete(event, el) {
            event.preventDefault();

            Swal.fire({
                icon: 'warning',
                title: 'Apakah anda yakin akan menghapus data?',
                text: 'Data yang sudah dihapus tidak dapat dikembalikan',
                showCancelButton: true,
            }).then(resp => {
                if (resp.isConfirmed) {
                    $("#delete-form").attr('action', $(el).attr('href'));
                    $("#delete-form").submit();
                }
            });
        }
        /* Formatting function for row details - modify as you need */
        function format(d) {

            if (!d.length) return $('<p>No Data</p>');

            const $table = $('<table class="table table-bordered"></table>');
            const $thead = $('<thead></thead>');
            const $trh = $('<tr><th>No. </th><th>Nama Penjemput</th><th>No Telpon</th></tr>');
            const $tbody = $('<tbody></tbody>');

            $thead.append($trh);
            $table.append($thead, $tbody);

            d.forEach(function(item, index) {
                const no = index + 1;
                $tbody.append(
                    `<tr><td>${no.toString()}</td><td>${item.nama_penjemput}</td><td>${item.no_penjemput}</td></tr>`
                );
            });

            // `d` is the original data object for the row
            return $table;
        }

        $(document).ready(function() {
            var table = $('#table_siswa').DataTable({
                columnDefs: [{
                    bSortable: false,
                    targets: [0, 4]
                }],
                order: [
                    [2, 'asc']
                ],
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "scrollX": true,
            });

            setTimeout(function() {
                $.fn.dataTable.tables({
                    visible: true,
                    api: true
                }).columns.adjust();
            }, 350);

            $('.nav-link').on('click', function() {
                setTimeout(function() {
                    $.fn.dataTable.tables({
                        visible: true,
                        api: true
                    }).columns.adjust();
                }, 350);
            });

            // Add event listener for opening and closing details
            $('#table_siswa tbody').on('click', 'td.dt-control', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var rowData = $(tr).data('penjemput');

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                    $(tr).find('.dt-control').find('i').removeClass('fa-minus-circle');
                    $(tr).find('.dt-control').find('i').addClass('fa-plus-circle');
                } else {
                    // Open this row
                    row.child(format(rowData)).show();
                    tr.addClass('shown');
                    $(tr).find('.dt-control').find('i').addClass('fa-minus-circle');
                    $(tr).find('.dt-control').find('i').removeClass('fa-plus-circle');
                }
            });
        });
    </script>
@stop
