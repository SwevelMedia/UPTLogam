@extends('layouts.template')

@push('css')
<style>
.edit-icon {
    top: 90%;
    left: 90%;
    transform: translate(-50%, -50%);
    background-color: rgba(255, 255, 255, 0.5);
    border-radius: 50%;
    padding: 5px;
    cursor: pointer;
}
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="card mb-4 me-sm-3">
        <div class="card-header border-bottom mb-3 pb-1">
            <p class="h4">Profil</p>
        </div>
        <div class="swal" data-swal="{{ session('success') }}"></div>
        <div class="card-body row">
            <div class="col-md-3 position-relative">
                @if ($errors->any())
                <div class="my-3">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
                <div class="mb-3"
                    style="width: 220px; height: 220px; overflow: hidden; display: block; margin-left: auto; margin-right: auto;">
                    @if ($data->photo == url('/storage/image/profile'))
                    <img src="{{ asset('/storage/image/profile/user.png') }}" class="img-fluid rounded-circle"
                        id="profile-image" style="width: 100%; height: 100%;">
                    @else
                    <img src="{{ $data->photo }}" alt="" class="img-fluid rounded-circle" id="profile-image"
                        style="width: 100%; height: 100%;">
                    @endif
                </div>


                <label for="file-input" class="edit-icon position-absolute">
                    <i class="fas fa-edit fs-6"></i>
                </label>
                <form action="{{ url('pp/update/' . $data->id) }}" method="post" enctype="multipart/form-data"
                    class="d-flex justify-content-center">
                    @csrf
                    <input type="file" id="file-input" class="d-none" name="photo" accept=".jpg, .jpeg, .png">
                    <input type="hidden" name="oldPhoto" value="{{ $data->photo }}">
                    <button type="submit" class="btn btn-sm btn-primary" id="save-button"
                        style="display: none;">Simpan</button>
                </form>
            </div>

            <div class="col-md-8 table-responsive">
                <table class="table align-items-center mb-0 px-3">
                    <tr>
                        <th>Nama</th>
                        <td>: {{ $data->name }}</td>
                    </tr>
                    <tr>
                        <th>NIP</th>
                        <td>: {{ $data->nip }}</td>
                    </tr>
                    <tr>
                        <th>Jabatan</th>
                        <td>: {{ strtoupper($data->role) }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Masuk</th>
                        <td>: {{ date('d M Y', strtotime($data->tanggal_masuk)) }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>: {{ $data->email }}</td>
                    </tr>
                    <tr></tr>
                </table>
            </div>

        </div>
    </div>
    <div class="swal" data-swal="{{ session('success') }}"></div>


    <div class="card me-sm-3">
        <div class="card-body">
            <p class="h4">Data Pribadi</p>
            <hr class="bg-secondary">
            @if ($errors->any())
            <div class="my-3">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <form method="post" class="row" action="{{ url('profile/update', $data->id) }}"
                enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="oldPhoto" id="" value="{{ $data->photo }}">

                <div class="form-group col-sm-6">
                    <label for="jk" class="form-control-label">Jenis Kelamin</label>
                    <select class="form-select form-control-md" name="gender" id="jk">
                        <option value="{{ $data->gender }}" selected hidden>{{ $data->gender }}</option>
                        <option value="laki-laki">Laki - Laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="form-group col-sm-6">
                    <label for="nik" class="form-control-label">NIK</label>
                    <input class="form-control" type="text" name="nik" placeholder="Masukkan NIK" id="nik"
                        value="{{ old('nik', $data->nik) }}">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" name="address" id="alamat" rows="3"
                        placeholder="Masukkan alamat lengkap disini">{{ old('address', $data->address) }}</textarea>
                </div>
                <div class="form-group col-sm-6">
                    <label for="tempat_lahir" class="form-control-label">Tempat Lahir</label>
                    <input class="form-control" type="text" name="tempat_lahir" id="tempat_lahir"
                        value="{{ old('tempat_lahir', $data->tempat_lahir) }}">
                </div>
                <div class="form-group col-sm-6">
                    <label for="tanggal_lahir" class="form-control-label">Tanggal Lahir</label>
                    <input class="form-control" type="date" name="tanggal_lahir" id="tanggal_lahir"
                        value="{{ old('tanggal_lahir', $data->tanggal_lahir) }}">
                </div>
                <div class="form-group col-sm-6">
                    <label for="gol_darah" class="form-control-label">Golongan Darah</label>
                    <input class="form-control" type="text" name="gol_darah" id="gol_darah"
                        value="{{ old('gol,darah', $data->gol_darah) }}">
                </div>

                <div class="form-group col-sm-6">
                    <label for="agama" class="form-control-label">Agama</label>
                    <input class="form-control" type="text" name="agama" id="agama"
                        value="{{ old('agama', $data->agama) }}">
                </div>
                <div class="form-group col-sm-6">
                    <label for="pendidikan" class="form-control-label">Pendidikan Terakhir</label>
                    <input class="form-control" type="text" name="pendidikan" id="pendidikan"
                        value="{{ old('pendidikan', $data->pendidikan) }}">
                </div>
                <div class="form-group col-sm-6">
                    <label for="status_nikah" class="form-control-label">Status Nikah</label>
                    <select class="form-select form-control-md" name="status_nikah" id="status_nikah">
                        <option value="{{ old('status_nikah', $data->status_nikah) }}" selected hidden>
                            {{ $data->status_nikah }}</option>
                        <option value="belum nikah">Belum Menikah</option>
                        <option value="nikah">Menikah</option>
                    </select>
                </div>
                <div class="form-group col-sm-6">
                    <label for="example-tel-input" class="form-control-label">Telepon</label>
                    <input class="form-control" type="tel" name="phone" id="example-tel-input"
                        value="{{ old('phone', $data->phone) }}">
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn bg-gradient-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script>
const swal = $('.swal').data('swal');
if (swal) {
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Success',
        text: swal,
        showConfirmButton: false,
        timer: 2000
    })
}
</script>
<script>
$(document).ready(function() {
    // Saat input file berubah
    $('#file-input').change(function() {
        var file = this.files[0]; // Ambil file yang dipilih
        if (file) {
            var reader = new FileReader(); // Membaca file
            reader.onload = function(e) {
                $('#profile-image').attr('src', e.target
                    .result); // Setel src gambar dengan hasil pembacaan
                $('#save-button').show();
            }
            reader.readAsDataURL(file); // Membaca file sebagai data URL
        }
    });
});
</script>
@endpush