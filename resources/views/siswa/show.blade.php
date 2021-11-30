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
                <img class="img-thumbnail img-fluid" src="{{ asset('foto_siswa') . '/' . $siswa->path_to_photo }}"
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
                console.log({
                    conf: resp.isConfirmed,
                    href: $(el).data('href'),
                });
                if (resp.isConfirmed) {
                    $("#delete-form").attr('action', $(el).attr('href'));
                    $("#delete-form").submit();
                }
            });
        }
    </script>
@stop
