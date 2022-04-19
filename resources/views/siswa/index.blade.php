@extends('adminlte::page')

@section('title', 'Data Siswa')

@section('content_header')

    Manage Siswa

@stop

@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm">
                                    <h2 class="float-left">Data Siswa</h2>
                                </div>
                                <div class="col-sm">
                                    <a type="button" class="btn btn-primary float-right"
                                        href="{{ route('siswa.create') }}">
                                        <i class="fa fa-plus-circle"></i>
                                        Tambah Siswa
                                    </a>
                                    {{-- <a type="button" style="margin-right:5px" class="btn btn-primary float-right">
                                        <i class="fa fa-filter"></i>
                                        Filter
                                    </a> --}}
                                </div>
                            </div>
                            {{-- <h2 class="float-left">Data Siswa</h2>
                            <a type="button" class="btn btn-primary float-right" href="{{ route('siswa.create') }}"><i
                                    class="fa fa-plus-circle"></i> Tambah
                                Siswa</a> --}}
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
                                                                    href="{{ route('siswa.destroy', ['siswa' => $siswa]) }}"><i
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
        @method('delete')
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
                    targets: [0, 1, 4]
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
