@extends('adminlte::page')

@section('title', 'Edit Siswa: ' . $siswa->nis)

@section('content_header')

    Edit Siswa

@stop

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Data Siswa</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('siswa.update', $siswa) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="inputNIS">NIS</label>
                    <input disabled type="text" class="form-control @error('nis') is-invalid @enderror" name="nis"
                        id="inputNIS" placeholder="NIS" value="{{ $siswa->nis }}">
                </div>
                <div class="form-group">
                    <label for="inputNama">Nama Lengkap</label>
                    <input type="text" class="form-control @error('nama_siswa') is-invalid @enderror" name="nama_siswa"
                        id="inputNama" placeholder="Nama Lengkap" value="{{ $siswa->nama_siswa }}">
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Ubah Foto
                    </label>
                </div>
                <div class="form-group photo-uploader">
                    <label for="inputFile">Foto</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="foto_siswa"
                                class="custom-file-input @error('foto_siswa') is-invalid @enderror" id="inputFile">
                            <label class="custom-file-label" for="inputFile">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a type="button" href="{{ route('siswa.show', ['siswa' => $siswa]) }}" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>


@stop

@section('css')

@stop

@section('js')
    <script>
        $(document).ready(function() {

            $('.photo-uploader').hide();
            $('#flexCheckDefault').on('change', function() {
                const changePhoto = $(this).is(":checked");
                const imageFile = $('#inputFile');

                if (changePhoto) {
                    $('.photo-uploader').show();
                } else {
                    $('.photo-uploader').hide();
                    imageFile.val('');
                }
            });
        });
    </script>

@stop
