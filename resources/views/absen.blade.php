@extends('adminlte::page')

@section('title', 'Data Siswa')

@section('content_header')

    Monitor Absen

@stop

@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="float-left">Data Absen</h2>
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
                                                    <th>Nama</th>
                                                    <th>Absen Masuk</th>
                                                    <th>Absen Keluar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr data-penjemput="">
                                                    <td>1</td>
                                                    <td>Hafizah Humairah</td>
                                                    <td>24-08-03 07:00</td>
                                                    <td>24-08-03 23:00</td>
                                                </tr>
                                                <tr data-penjemput="">
                                                    <td>2</td>
                                                    <td>Nasrudin</td>
                                                    <td>24-08-03 07:00</td>
                                                    <td>24-08-03 23:00</td>
                                                </tr>
                                                <tr data-penjemput="">
                                                    <td>3</td>
                                                    <td>Andi Siregar</td>
                                                    <td>24-08-03 07:00</td>
                                                    <td>24-08-03 23:00</td>
                                                </tr>
                                                <tr data-penjemput="">
                                                    <td>4</td>
                                                    <td>Natasha Bigof</td>
                                                    <td>24-08-03 07:00</td>
                                                    <td>24-08-03 23:00</td>
                                                </tr>
                                                <tr data-penjemput="">
                                                    <td>5</td>
                                                    <td>Daniel Kuwanto</td>
                                                    <td>24-08-03 07:00</td>
                                                    <td>24-08-03 23:00</td>
                                                </tr>
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
