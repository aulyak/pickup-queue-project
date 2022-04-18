@extends('adminlte::page')

@section('title', 'Data Siswa')

@section('content_header')

    Monitoring Penjemputan

@stop

@section('content')

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
                                                        <td>{{ $penjemputan->created_at->toDayDateTimeString() }}
                                                            ({{ $penjemputan->created_at->diffForHumans() }})
                                                        </td>
                                                        <td>{{ $penjemputan->updated_at->toDayDateTimeString() }}
                                                            ({{ $penjemputan->updated_at->diffForHumans() }})</td>
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
