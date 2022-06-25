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
                                                    <th>No.</th>
                                                    <th>NIS</th>
                                                    <th>Nama Siswa</th>
                                                    <th>Assigned Penjemput</th>
                                                    <th>ID Penjemput</th>
                                                    <th>Status Penjemputan</th>
                                                    <th>Created at</th>
                                                    <th>Last Updated at</th>
                                                    <th>Cancel</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $key => $penjemputan)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $penjemputan->siswa->nis }}</td>
                                                        <td>{{ $penjemputan->siswa->nama_siswa }}</td>
                                                        <td>
                                                            {{ $penjemputan->penjemput ? $penjemputan->penjemput->nama_penjemput : '-' }}
                                                        </td>
                                                        <td>{{ $penjemputan->assigned_penjemput }}</td>
                                                        <td>{{ $penjemputan->status_penjemputan }}</td>
                                                        <td data-sort="{{ $penjemputan->created_at }}">
                                                            {{ $penjemputan->created_at->toDayDateTimeString() }}
                                                            ({{ $penjemputan->created_at->diffForHumans() }})
                                                        <td data-sort="{{ $penjemputan->updated_at }}">
                                                            {{ $penjemputan->updated_at->toDayDateTimeString() }}
                                                            ({{ $penjemputan->updated_at->diffForHumans() }})</td>
                                                        <td>
                                                            @if ($penjemputan->status_penjemputan != 'canceled')
                                                                <div class="btn-group">
                                                                    <a type="button" class="btn btn-danger mr-1"
                                                                        onclick="notificationBeforeCancel(event, this)"
                                                                        href={{ route('penjemputan.cancel', ['penjemputan' => $penjemputan]) }}><i
                                                                            class="fa fa-times"></i></a>
                                                                </div>
                                                            @endif
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
    <form action="" id="put-form" method="post">
        @method('put')
        @csrf
    </form>
    <script>
        function notificationBeforeCancel(event, el) {
            event.preventDefault();

            Swal.fire({
                icon: 'warning',
                title: 'Apakah anda yakin akan mengcancel penjemputan?',
                text: 'Proses ini tidak dapat di-reverse.',
                showCancelButton: true,
            }).then(resp => {
                if (resp.isConfirmed) {
                    $("#put-form").attr('action', $(el).attr('href'));
                    $("#put-form").submit();
                }
            });
        }

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
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "scrollX": true,
            });
        });
    </script>

@stop
