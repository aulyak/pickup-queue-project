<div class="modal fade" id="modal-lg-{{ $type }}" style="display: none;" aria-hidden="true"
    data-penjemput="">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $type == 'create' ? 'Tambah Penjemput' : 'Edit Penjemput' }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('penjemput.store') }}" method="POST">
                    @if ($type == 'edit')
                        @method('PUT')
                    @endif
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputNamaSiswa">Nama Siswa</label>
                            <input disabled type="text" class="form-control" id="inputNamaSiswa"
                                value="{{ $namaSiswa }}">
                        </div>
                        <div class="form-group">
                            <label for="inputNIK">NIK Siswa</label>
                            <input disabled type="text" class="form-control @error('nik_siswa') is-invalid @enderror"
                                id="inputNIK" value="{{ $nikSiswa }}">
                        </div>
                        <div class="form-group">
                            <label for="inputNama">Nama Penjemput</label>
                            <input type="text" class="form-control @error('nama_penjemput') is-invalid @enderror"
                                name="nama_penjemput" id="inputNama" placeholder="Nama Lengkap" value="">
                        </div>
                        <div class="form-group">
                            <label for="inputTelpon">No. Telpon</label>
                            <input type="text" class="form-control @error('no_penjemput') is-invalid @enderror"
                                name="no_penjemput" id="inputTelpon" placeholder="No. Telpon" value="">
                        </div>
                    </div>
                    <!-- /.card-body -->
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="submit" class="btn btn-primary form-submit-modal">Submit</button>
                <a type="button" data-toggle="modal" data-target="#modal-lg-{{ $type }}"
                    class="btn btn-danger">Cancel</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
