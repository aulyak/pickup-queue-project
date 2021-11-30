@extends('adminlte::page')

@section('title', 'Tambah Siswa')

@section('content_header')

    Tambah Siswa

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
        <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="inputNIK">NIK</label>
                    <input type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" id="inputNIK"
                        placeholder="NIK" value="{{ old('nik') }}">
                </div>
                <div class="form-group">
                    <label for="inputNama">Nama Lengkap</label>
                    <input type="text" class="form-control @error('nama_siswa') is-invalid @enderror" name="nama_siswa"
                        id="inputNama" placeholder="Nama Lengkap" value="{{ old('nama_siswa') }}">
                </div>
                <div class="form-group">
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
                <a type="button" href="{{ route('siswa.index') }}" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>


@stop

@section('css')

@stop
