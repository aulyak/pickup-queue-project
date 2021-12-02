@php
function encodeURIComponent($str)
{
    $revert = ['%21' => '!', '%2A' => '*', '%27' => "'", '%28' => '(', '%29' => ')'];
    return strtr(rawurlencode($str), $revert);
}
@endphp

@extends('adminlte::page')

@section('title', 'Detail Siswa: ' . $siswa->nik)

@section('content_header')

    Detail Siswa: <b>{{ ucwords($siswa->nama_siswa) }}</b>

@stop

@section('content')

    <div class="card card-primary card-outline">
        <div class="card-header">
            <div class="btn-group btn-block">
                <a type="button" href="{{ route('siswa.index') }}" class="btn btn-info mr-2">
                    <i class="fas fa-home"></i>
                </a>
                <a type="button" href="{{ route('siswa.edit', ['siswa' => $siswa]) }}" class="btn btn-success mr-2">
                    <i class="fas fa-edit"></i>
                </a>
                <a type="button" class="btn btn-danger mr-2" onclick="notificationBeforeDelete(event, this)"
                    href="{{ route('siswa.destroy', ['siswa' => $siswa]) }}">
                    <i class="fas fa-trash"></i>
                </a>
            </div>
        </div>
        <div class="card-body box-profile">
            <div class="text-center">
                <img class="img-thumbnail img-fluid" src="{{ asset('storage/foto_siswa/' . $siswa->path_to_photo) }}"
                    alt="User profile picture">
            </div>

            <h3 class="profile-username text-center">{{ ucwords($siswa->nama_siswa) }}</h3>

            {{-- <p class="text-muted text-center">{{ $siswa->nik }}</p> --}}

            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>NIK</b> <a class="float-right">{{ $siswa->nik }}</a>
                </li>
                <li class="list-group-item">
                    <b>Created At</b> <a class="float-right">{{ $siswa->created_at->toDayDateTimeString() }}
                        ({{ $siswa->created_at->diffForHumans() }})</a>
                </li>
                <li class="list-group-item">
                    <b>Updated At</b> <a class="float-right">{{ $siswa->updated_at->toDayDateTimeString() }}
                        ({{ $siswa->updated_at->diffForHumans() }})</a>
                </li>
            </ul>

            {{-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
        </div>
        <!-- /.card-body -->
    </div>
    <div class="card">
        <div class="card-header">
            <h2 class="float-left">Data Penjemput</h2>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-lg-create">
                Tambah Penjemput
            </button>
            {{-- <a type="button" class="btn btn-primary float-right" href="{{ route('penjemput.create') }}"><i
                    class="fa fa-plus-circle"></i> Tambah
                Penjemput</a> --}}
        </div>
        <div class="card-body">
            <div id="table_penjemput_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12 col-md-6"></div>
                    <div class="col-sm-12 col-md-6"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="table_penjemput" class="table table-bordered table-hover dataTable dtr-inline"
                            role="grid" aria-describedby="table_penjemput_info">
                            <thead>
                                <tr role="row">
                                    <th>No.</th>
                                    <th>NIK SISWA</th>
                                    <th>Nama</th>
                                    <th>No. Penjemput</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_penjemput as $key => $penjemput)
                                    <tr>
                                        <td>{{ $penjemput->id }}</td>
                                        <td>{{ $penjemput->nik_siswa }}</td>
                                        <td>{{ ucwords($penjemput->nama_penjemput) }}</td>
                                        <td>{{ $penjemput->no_penjemput }}</td>
                                        <td>{{ $penjemput->created_at }}</td>
                                        <td>{{ $penjemput->updated_at }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a type="button" class="btn btn-success mr-1" data-toggle="modal"
                                                    data-target="#modal-lg-edit"
                                                    data-penjemput={{ encodeURIComponent($penjemput) }}><i
                                                        class="fa fa-edit"></i></a>
                                                <a type="button" class="btn btn-danger mr-1"
                                                    onclick="notificationBeforeDelete(event, this)"
                                                    href="{{ route('penjemput.destroy.redirect', ['penjemput' => $penjemput, 'siswa' => $siswa]) }}"><i
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
    </div>

    <x-modal :namaSiswa="$siswa->nama_siswa" :nikSiswa="$siswa->nik" :type="'create'"></x-modal>
    <x-modal :namaSiswa="$siswa->nama_siswa" :nikSiswa="$siswa->nik" :type="'edit'"></x-modal>

@stop

@section('css')

@stop

@section('js')

    <form action="" id="delete-form" method="post">
        @method('delete')
        @csrf
    </form>
    <script>
        function resetForm(modal) {
            $(modal).find("#inputNama").val('');
            $(modal).find("#inputTelpon").val('');
        }

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

        $(document).ready(function() {
            $('#modal-lg-edit').on('shown.bs.modal', function(e) {
                console.log('yo');
                var link = e.relatedTarget;
                var modal = $(this);
                var penjemput = JSON.parse(decodeURIComponent($(link).data('penjemput')));
                console.log({
                    penjemput
                });
                modal.data('penjemput', penjemput);

                modal.find('#inputNama').val(penjemput.nama_penjemput);
                modal.find('#inputTelpon').val(penjemput.no_penjemput);
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.modal').on('hidden.bs.modal', function(e) {
                resetForm($(this));
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.form-submit-modal').on('click', function(e) {
                e.preventDefault();
                var baseUrl = "{{ URL::to('/') }}";

                var modal = $(this).closest('.modal');
                var type = modal.attr('id').split('-')[2];
                var penjemput = $(modal).data('penjemput');

                console.log({
                    penjemput
                });

                var nik_siswa = $(modal).find('#inputNIK').val();
                var nama_penjemput = $(modal).find("#inputNama").val();
                var no_penjemput = $(modal).find("#inputTelpon").val();
                var penjemputId = penjemput.id;

                var httpMethod = type === 'create' ? 'POST' : 'PUT';
                var editUrl = `${baseUrl}/penjemput/byid/${penjemputId}`;
                var url = type === 'create' ?
                    "{{ route('penjemput.store') }}" : editUrl;
                console.log({
                    nik_siswa,
                    nama_penjemput,
                    no_penjemput
                });

                $.ajax({
                    type: httpMethod,
                    url,
                    data: {
                        nik_siswa,
                        nama_penjemput,
                        no_penjemput
                    },
                    success: function(data) {
                        console.log(data);
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses.',
                            text: data.success,
                            timer: 2000,
                        }).then(() => {
                            $(modal).modal('toggle');
                            location.reload();
                        });
                    },
                    error: function(error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: JSON.stringify(error.responseJSON.errors, null, 2),
                        });
                    },
                });

            });

            var table = $('#table_penjemput').DataTable({
                columnDefs: [{
                    bSortable: false,
                    targets: [0, 3, 6]
                }],
                order: [
                    [1, 'asc']
                ],
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@stop
