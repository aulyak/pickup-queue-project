@extends('adminlte::page')

@section('title', 'Penjemputan')

@section('content_header')

    &nbsp

@stop

@section('content')
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
                            <h2 class="float-left">Data Penjemputan</h2>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div id="table_penjemputan_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6"></div>
                                    <div class="col-sm-12 col-md-6"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="table_penjemputan"
                                            class="table table-bordered table-hover dataTable dtr-inline" role="grid"
                                            aria-describedby="table_penjemputan_info">
                                            <thead>
                                                <tr role="row">
                                                    <th>NIS</th>
                                                    <th>Nama Siswa</th>
                                                    <th>Assigned Penjemput</th>
                                                    <th>Status Penjemputan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
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
    <script>
        $(document).ready(function() {

            $('.nav-link').on('click', function() {
                setTimeout(function() {
                    $.fn.dataTable.tables({
                        visible: true,
                        api: true
                    }).columns.adjust();
                }, 350);
            });

            var table = $('#table_penjemputan').DataTable({
                "serverSide": true,
                ajax: "{{ route('penjemputan.ajax') }}",
                columns: [{
                        data: 'nis',
                    },
                    {
                        data: 'nama_siswa',
                    },
                    {
                        data: 'assigned_penjemput',
                    },
                    {
                        data: 'status_penjemputan',
                    },
                ],
                "paging": false,
                "searching": false,
                "lengthChange": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "scrollX": true,
            });

            setInterval(function() {
                table.ajax.reload(null, false);
            }, 1000);
        });
    </script>
@stop
