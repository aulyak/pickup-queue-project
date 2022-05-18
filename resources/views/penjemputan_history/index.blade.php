@extends('adminlte::page')

@section('title', 'History Penjemputan')

@section('content_header')

    &nbsp

@stop

@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="float-left">Penjemputan History</h2>
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
                                                    <th>Tanggal Scan</th>
                                                    <th>Last Updated at</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $key => $penjemputanHistory)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $penjemputanHistory->siswa->nis }}</td>
                                                        <td>{{ $penjemputanHistory->siswa->nama_siswa }}</td>
                                                        <td>
                                                            {{ $penjemputanHistory->penjemput ? $penjemputanHistory->penjemput->nama_penjemput : '-' }}
                                                        </td>
                                                        <td>{{ $penjemputanHistory->assigned_penjemput }}</td>
                                                        <td>{{ $penjemputanHistory->status_penjemputan }}</td>
                                                        <td>{{ $penjemputanHistory->created_at->toDayDateTimeString() }}
                                                            ({{ $penjemputanHistory->created_at->diffForHumans() }})
                                                        </td>
                                                        <td>{{ $penjemputanHistory->updated_at->toDayDateTimeString() }}
                                                            ({{ $penjemputanHistory->updated_at->diffForHumans() }})</td>
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

    <script>
        $(document).ready(function() {
            var table = $('#table_penjemputan').DataTable({
                // columnDefs: [{
                //     bSortable: false,
                //     targets: [0, 1, 4]
                // }],
                // order: [
                //     [2, 'asc']
                // ],
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
