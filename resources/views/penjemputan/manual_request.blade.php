@extends('adminlte::page')

@section('title', 'Tambah Siswa')

@section('content_header')

    &nbsp

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

    <div class="card">
        <div class="card-header">
            <h2 class="float-left">Data Penjemputan</h2>
        </div>
        <form>
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="inputNIS">Pilih Siswa</label>
                    &nbsp
                    <select class="select-nis form-control" name="nis" id="inputNIS">
                        @foreach ($data as $key => $siswa)
                            <option value="{{ $siswa->nis }}">{{ $siswa->nama_siswa }} ({{ $siswa->nis }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>


@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select-nis').select2();
        });

        $('form').submit(function(e) {
            const nis = $('#inputNIS').val();
            e.preventDefault();

            $.ajax({
                type: 'POST',
                data: {
                    nis
                },
                url: "{{ route('api.penjemputan.store') }}",
                headers: {
                    'Accept': 'application/json',
                    'x-api-key': '3c2fd289-b0c7-4be4-9ed9-6323a65ecc94',
                },
                success: function(data, status, xhr) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Manual request was successful.'
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: `${xhr.responseJSON.message}`,
                        text: `${xhr.responseJSON.data}`
                    });
                }
            });
        });
    </script>
@stop
