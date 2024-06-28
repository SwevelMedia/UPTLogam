@extends('layouts.template')

@push('css')
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="card mb-4 me-sm-3">
            <div class="card-header pb-0 border-bottom mb-3">
                <a href="{{ route('karyawan.index') }}">
                    <h6 class="text-info"><i class="fas fa-chevron-left"></i> Kembali</h6>
                </a>
                <p class="h4">Tambah Karyawan</p>
            </div>
            <div class="swal" data-swal="{{ session('success') }}"></div>
            <div class="card-body pt-0">
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
                <form method="post" action="{{ url('/karyawan') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="accordion" id="accordionRental">
                        <div class="accordion-item">
                            <h5 class="accordion-header" id="headingOne">
                                <button class="accordion-button border-bottom font-weight-bold collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    Harus di isi
                                    <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                        aria-hidden="true"></i>
                                    <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                        aria-hidden="true"></i>
                                </button>
                            </h5>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordionRental" style="">
                                <div class="accordion-body text-sm opacity-8 row">
                                    <div class="form-group col-sm-6">
                                        <label for="name" class="form-control-label">Nama Karyawan <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="name"
                                            placeholder="Masukkan nama lengkap karyawan" id="name" required
                                            value="{{ old('name') }}">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="nip" class="form-control-label">Nomor Induk Pegawai <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="nip"
                                            placeholder="Masukkan NIP karyawan" id="nip" required
                                            value="{{ old('nip') }}">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="role" class="form-control-label">Jabatan <span
                                                class="text-danger">*</span></label>
                                        <select id="role" class="form-select" name="role" required autofocus
                                            autocomplete="role" style="background-color: transparent;" required>
                                            <option value="" hidden class="text-da">Select Role</option>
                                            <option value="admin">Admin</option>
                                            <option value="ppic">PPIC</option>
                                            <option value="programmer">Programmer</option>
                                            <option value="drafter">Drafter</option>
                                            <option value="toolman">Tools Man</option>
                                            <option value="operator">Operator</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="tanggal_masuk" class="form-control-label">Tanggal Masuk <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" type="date" name="tanggal_masuk" id="tanggal_masuk"
                                            value="{{ old('tanggal_masuk') }}" required>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="email" class="form-control-label">Email <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" type="email" name="email"
                                            placeholder="masukkan email" id="email" required
                                            value="{{ old('email') }}">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="pass" class="form-control-label">Password <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" type="password" name="password"
                                            placeholder="masukkan password" id="pass" autocomplete="new-password"
                                            required value="{{ old('password') }}">
                                    </div>
                                    {{-- <input type="text" class="form-control" name="city" list="cityname">
                                    <datalist id="cityname">
                                        <option value="Blida">
                                        <option value="OuledSlama">
                                    </datalist> --}}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h5 class="accordion-header" id="headingTwo">
                                <button class="accordion-button border-bottom font-weight-bold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                    aria-controls="collapseTwo">
                                    Detail Karyawan
                                    <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                        aria-hidden="true"></i>
                                    <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                        aria-hidden="true"></i>
                                </button>
                            </h5>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionRental">
                                <div class="accordion-body text-sm opacity-8 row">
                                    <div class="form-group col-sm-6">
                                        <label for="jk" class="form-control-label">Jenis Kelamin</label>
                                        <select class="form-select form-control-md" name="gender" id="jk">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="laki-laki">Laki - Laki</option>
                                            <option value="perempuan">Perempuan</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="nik" class="form-control-label">Nomor Induk Kependudukan</label>
                                        <input class="form-control" type="text" name="nik"
                                            placeholder="Masukkan NIK" id="nik" value="{{ old('nik') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea class="form-control" name="address" id="alamat" rows="3"
                                            placeholder="Masukkan alamat lengkap disini">{{ old('address') }}</textarea>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="tempat_lahir" class="form-control-label">Tempat Lahir</label>
                                        <input class="form-control" type="text" name="tempat_lahir" id="tempat_lahir"
                                            value="{{ old('tempat_lahir') }}">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="tanggal_lahir" class="form-control-label">Tanggal Lahir</label>
                                        <input class="form-control" type="date" name="tanggal_lahir"
                                            id="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="gol_darah" class="form-control-label">Golongan Darah</label>
                                        <input class="form-control" type="text" name="gol_darah" id="gol_darah"
                                            value="{{ old('gol,darah') }}">
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="agama" class="form-control-label">Agama</label>
                                        <input class="form-control" type="text" name="agama" id="agama"
                                            value="{{ old('agama') }}">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="pendidikan" class="form-control-label">Pendidikan Terakhir</label>
                                        <input class="form-control" type="text" name="pendidikan" id="pendidikan"
                                            value="{{ old('pendidikan') }}">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="status_nikah" class="form-control-label">Status Nikah</label>
                                        <select class="form-select form-control-md" name="status_nikah"
                                            id="status_nikah">
                                            <option value="" hidden>--Pilih--</option>
                                            <option value="belum nikah">Belum Menikah</option>
                                            <option value="nikah">Menikah</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="example-tel-input" class="form-control-label">Phone</label>
                                        <input class="form-control" type="tel" name="phone" id="example-tel-input"
                                            value="{{ old('phone') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="example-password-input" class="form-control-label">Foto</label>
                                        <input class="form-control" type="file" name="photo"
                                            id="example-password-input" value="{{ old('photo') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
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
@endpush
